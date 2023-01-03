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

        // Create the new upload
        $new_upload = new Upload();
        $new_upload->title = 'test'; // TODO: Get from request
        $new_upload->description = 'test'; // TODO: Get from request
        $new_upload->project()->associate($project_id);
        $new_upload->save();

        // Upload the links
        $filled_links = array_values(get_object_vars((object) array_filter($request->input('upload_link') ?? [], fn($link) => !empty($link))));
        $filled_files = array_values(get_object_vars((object) array_filter($request->file('upload_file') ?? [], fn($file) => !empty($file))));

        if(sizeof($filled_links) > 0){
            foreach($filled_links as $link){
                // Create the link instance
                $new_uploadable_link = new LinkUpload();
                $new_uploadable_link->link = $link;
                $new_uploadable_link->save();
                // Associate the upload with the link
                $new_uploadable_link->uploads()->save($new_upload);
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
                $new_uploadable_file->uploads()->save($new_upload);
            }
        }

        return redirect()->route('project_details_page', [$course_id, $lesson_id, $project_id]);
    }
}
