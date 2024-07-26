<?php 

function get_scorm_file_path($course_id) {
   $upload_dir = wp_upload_dir(); // Fetches the current upload directory info
   $scorm_dir = $upload_dir['basedir'] . '/scorm_packages'; // Appends a subdirectory for SCORM packages

   // Ensure the SCORM directory exists
   if (!file_exists($scorm_dir)) {
       wp_mkdir_p($scorm_dir); // Creates the directory if it doesn't exist
   }

   $filename = $scorm_dir . "/course_{$course_id}.zip";
   return $filename;
}


  if ( ! function_exists('get_course_data') ) {
   function get_course_data( $course_id ) {
      $course = get_post( $course_id );
      $course_meta = get_post_meta( $course_id );
      
      $course_content = $course_meta['course_content'] ?? 'No content available.';
      
      return [
          'title' => $course->post_title,
          'content' => $course_content,
      ];
  }

  if ( ! function_exists('create_scorm_manifest') ) {
   function create_scorm_manifest($course_data) {
      $dom = new DOMDocument('1.0', 'UTF-8');
      $dom->formatOutput = true;
      
      // Root element
      $manifest = $dom->createElement('manifest');
      $manifest->setAttribute('identifier', 'com.example.course.' . uniqid());
      $manifest->setAttribute('version', '1.1');
      $manifest->setAttribute('xmlns', 'http://www.imsproject.org/xsd/imscp_rootv1p1p2');
      $dom->appendChild($manifest);
      
      // Organizations (required by SCORM)
      $organizations = $dom->createElement('organizations');
      $organization = $dom->createElement('organization');
      $organization->setAttribute('identifier', 'org1');
      $items = $dom->createElement('item');
      $items->setAttribute('identifier', 'item1');
      $items->setAttribute('identifierref', 'resource1');
      $itemtitle = $dom->createElement('title', $course_data['title']);
      $items->appendChild($itemtitle);
      $organization->appendChild($items);
      $organizations->appendChild($organization);
      $manifest->appendChild($organizations);
      
      // Resources (required by SCORM)
      $resources = $dom->createElement('resources');
      $resource = $dom->createElement('resource');
      $resource->setAttribute('identifier', 'resource1');
      $resource->setAttribute('type', 'webcontent');
      $resource->setAttribute('href', 'index.html');
      $file = $dom->createElement('file');
      $file->setAttribute('href', 'index.html');
      $resource->appendChild($file);
      $resources->appendChild($resource);
      $manifest->appendChild($resources);
      
      return $dom->saveXML();
   }
  }

  if ( ! function_exists('') ) {
   function create_scorm_package($course_id) {
      $course_data = get_course_data($course_id);

      wp_send_json_success( [
         'status' => 'success',
         'data' => $course_data
      ] );

      // $manifest_xml = create_scorm_manifest($course_data);
  
      // $zip = new ZipArchive();
      // $filename = get_scorm_file_path( $course_id );
  
      // if ($zip->open($filename, ZipArchive::CREATE) !== TRUE) {
      //     exit("Cannot open <$filename>\n");
      // }
  
      // // Add the manifest file
      // $zip->addFromString('imsmanifest.xml', $manifest_xml);
  
      // // Add course content file (you would need to create this HTML file based on your course data)
      // $zip->addFromString('index.html', '<html><body>' . htmlspecialchars($course_data['content']) . '</body></html>');
  
      // // All files are added, now close the zip file
      // $zip->close();
  
      // // Optionally, force download the zip file
      // header('Content-Type: application/zip');
      // header('Content-disposition: attachment; filename=' . basename($filename));
      // header('Content-Length: ' . filesize($filename));
      // readfile($filename);
   }
  
  }
  
 }