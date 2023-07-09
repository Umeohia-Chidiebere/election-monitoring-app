<?php
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

function resize_and_save_image($img, $path, $insert_watermark = false, $width = 500, $height = 500)
{
    $image  = Image::make($img)->resize($width, $height, function($constraint){
                    $constraint->aspectRatio();
                });
    if($insert_watermark):
            $watermark_url = public_path();
            $watermark = Image::make( $watermark_url )->resize( 50, 30, function( $constraint ){
                $constraint->aspectRatio();
            });   
            $image->insert($watermark, 'bottom-left');
    endif;
    $image->save( $path );
}

function upload_image($img, $path)
{
    $filename = random_strings().file_extension($img);
    $path = $path.$filename;
    resize_and_save_image($img, $path);
    return $filename;
}

function upload_document($file, $path)
{
    $filename = random_strings().file_extension($file);
    $file->move($path, $filename);
    return $filename;
}

function file_type( $file )
{
    return explode('/', $file->getClientMimeType() )[0];
}

function file_type_name( $file )
{
    if( file_type($file) == "image") return "image";
    if( file_type($file) == "audio") return "audio";
    if( file_type($file) == "video") return "video";
    return "docs";
}

function upload_file_($file, $path)
{
    if( ! file_type_name($file) == 'image' || ! file_type_name($file) == 'video') return 0;
    if( file_type($file) == 'image') return upload_image($file, $path);
    return upload_document($file, $path);
}

function upload_multiple_files(array $files, $path)
{
    $doc = [];
    foreach( $files as $file){
        $filename = upload_file_( $file, $path ) ;
        if( $filename == 0) return 0; 
        $doc[] = ['file_name'=> $filename, 'file_type' => file_type_name($file) ];
    }
    return $doc;
}

function file_size($file)
{
    return $file->getSize();
}

function file_size_in_mb( $file_size )
{
    return number_format( $file_size / 1048576, 2 );
}

function file_size_in_kb( $file_size )
{
    return number_format( $file_size / 1025, 2 ); 
}

function file_extension($file, $concat = '.')
{
    $ext = $file->getClientOriginalExtension();
    if( file_type_name( $file ) == 'image' ) $ext = "png";
    if( file_type_name( $file ) == 'video' ) $ext = "mp4";
    if( file_type_name( $file ) == 'audio' ) $ext = "mp3";
    return $concat.$ext;
}
 
function delete_file_from_folder($path, $file_name ) 
{
    return File::delete($path.$file_name);
}

function upload_folder()
{
    return "uploads/";
}

function logo()
{
    return '/assets/images/logo.png'; 
}

function party_logo_folder()
{
    return upload_folder()."party_logo/";
}

function post_folder()
{
    return upload_folder()."posts/";
}

function profile_image_folder()
{
    return upload_folder()."profile-image/";
}

function verification_docs_folder()
{
    return upload_folder()."verification-docs/";
}

