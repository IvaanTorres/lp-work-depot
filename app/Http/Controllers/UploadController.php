<?php

namespace App\Http\Controllers;

use App\Models\FileUpload;
use App\Models\LinkUpload;
use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
        $this->middleware('roles:student,teacher', ['except' => ['download_file']]);
        // $this->middleware('roles:teacher', ['except' => ['destroy', 'download_file']]);
    }
    
    public function destroy(Request $request, $course_id, $lesson_id, $project_id, $document_id){
        $document = LinkUpload::find($document_id) ?? FileUpload::find($document_id);
        
        if(get_class($document) == FileUpload::class){
            // Delete the file
            Storage::delete($document->file_url);
        }
        // Delete the upload content
        $document->delete();

        return redirect()->back()->with('upload_delete_info', 'Upload content deleted successfully!');
    }

    public function download_file(Request $request, $course_id, $lesson_id, $project_id, $file_id){
        $file = FileUpload::find($file_id);
        return Storage::download($file->file_url);
    }

    public function store(Request $request, $course_id, $lesson_id, $project_id){
        $request->validate([
            'upload_title' => 'required|string|max:255',
            'upload_description' => 'nullable|string|max:255',
            'upload_link' => 'nullable|array',
            'upload_link.*' => 'nullable|url',
            'upload_file' => 'nullable|array|max:5',
            'upload_file.*' => 'nullable|file|max:10240|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar,7z,txt,mp4,mp3,avi,wmv,mkv,flv,mov,webm,ogg,ogv,svg,svgz,png,jpg,jpeg,gif,ico',
        ]);

        $upload = Upload::where('user_id', Auth()->user()->id)->where('project_id', $project_id)->first();

        if(!$upload){
            // Create the new upload
            $upload = new Upload();
            $upload->title = $request->input('upload_title');
            $upload->description = $request->input('upload_description');
            $upload->project()->associate($project_id);
            $upload->user()->associate(Auth()->user()->id);
            $upload->save();
        }

        $upload->title = $request->input('upload_title');
        $upload->description = $request->input('upload_description');
        $upload->save();

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
                $new_uploadable_link->uploads()->save($upload);
            }
        }

        // Upload the files
        if(sizeof($filled_files) > 0){
            $directory_path = 'public/uploads/project_' . $project_id . '/user_' . Auth()->user()->id;
            if(!Storage::exists($directory_path)){
                Storage::makeDirectory($directory_path, 0777, true, true);
            }

            foreach($filled_files as $file){
                // Create the file instance
                $new_uploadable_file = new FileUpload();
                $file_path = $file->store($directory_path);

                $new_uploadable_file->title = $file->getClientOriginalName();
                $new_uploadable_file->file_url = $file_path;
                $new_uploadable_file->save();
                // // // // Associate the upload with the file
                $new_uploadable_file->uploads()->save($upload);
            }
        }

        return back()
            ->with('course_id', $course_id)
            ->with('lesson_id', $lesson_id)
            ->with('project_id', $project_id)
            ->with('upload_create_info', 'Upload created/modified successfully!');
    }
}
