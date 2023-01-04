<?php

namespace App\Http\Controllers;

use App\Models\FileUpload;
use App\Models\LinkUpload;
use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function store(Request $request, $course_id, $lesson_id, $project_id){
        // $request->validate([
        //     'upload_file' => 'required', // TODO: Add validation for file type
        // ]);

        $upload = Upload::where('user_id', Auth()->user()->id)->where('project_id', $project_id)->first();
        // Upload already exists, delete it
        if($upload){
            // Delete the upload content
            $upload->links()->delete();
            $upload->files()->delete();
        }else{
            // Create the new upload
            $upload = new Upload();
            $upload->title = 'test'; // TODO: Get from request
            $upload->description = 'test'; // TODO: Get from request
            $upload->project()->associate($project_id);
            $upload->user()->associate(Auth()->user()->id);
            $upload->save();
        }
        // dd($upload);

        // Upload the links
        $filled_links = array_values(get_object_vars((object) array_filter($request->input('upload_link') ?? [], fn($link) => !empty($link))));
        $filled_files = array_values(get_object_vars((object) array_filter($request->file('upload_file') ?? [], fn($file) => !empty($file))));

        if(sizeof($filled_links) > 0){
            // Delete links on db

            foreach($filled_links as $link){
                // Create the link instance
                $new_uploadable_link = new LinkUpload();
                $new_uploadable_link->link = $link;
                $new_uploadable_link->save();
                // Associate the upload with the link
                $new_uploadable_link->uploads()->save($upload);
            }
        }

        // Upload the files
        if(sizeof($filled_files) > 0){
            $file_path = 'public/uploads/project_' . $project_id . '/user_' . Auth()->user()->id;
            Storage::makeDirectory($file_path, 0755, true, true);

            foreach($filled_files as $file){
                
                // Create the file instance
                $new_uploadable_file = new FileUpload();
                $file_path = $file->store($file_path);
                $new_uploadable_file->file_url = $file_path;
                $new_uploadable_file->save();
                // // // Associate the upload with the file
                $new_uploadable_file->uploads()->save($upload);
            }
        }

        return back()
            ->with('course_id', $course_id)
            ->with('lesson_id', $lesson_id)
            ->with('project_id', $project_id);
    }
}
