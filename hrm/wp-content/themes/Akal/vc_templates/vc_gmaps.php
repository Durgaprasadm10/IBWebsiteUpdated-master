<?php
		$map_id = rand() ;
		global $brad_data , $brad_includes;
		$output = $el_class = '';
		
        extract(shortcode_atts(array(
		      'style' => 'default' ,
		      'address' => '',
			  'width' => '100%',
			  'lat' => '',
			  'lon' => '',
			  'custominfo' => 'no',
			  'bg_color' => '',
			  'txt_color' => '',
		      'height' => '300px',
		      'zoom' => '14',
		      'scrollwheel' => 'true',
		      'scale' => 'true',
			  'streetview' => 'false',
			  'maptypecontrol' => 'false',
			  'mappan' => 'false',
			  'zoomcontrol' => 'true',
			  'zoomsize' => 'small',
			  'infowindow' => '',
			  'infovisible' => 'no',
			  'maptype' => 'roadmap',
			  'marker' => 'no',
		      'markerimage' => '',
			  'markers' => '',
			  'el_class' => ''
	           ), $atts));
		
		
	  if ($markerimage !=''){
		   $img_id = preg_replace('/[^\d]/', '', $markerimage);
           $img_src =  wp_get_attachment_image_src( $img_id , '');				
		   $image = $img_src[0];
	  }
	  else{
		 $image = '';
	  }
	  
	  if($marker == 'yes'){
	  $global_markers = array();
	  $global_markers[1]['desc'] = $infowindow ;
	  $global_markers[1]['img'] = $image;
	  $global_markers[1]['visible'] = $infovisible;
			  
	  
	  if($markers != ''){
		  $markers_array = explode("\n", $markers);	
		  $i = 2 ;
		  foreach($markers_array as $marker_array){
              if(!empty($marker_array)){
		
			  $new_marker_array =  explode('|', $marker_array);
			  
			  $global_markers[$i]['lat'] = !empty($new_marker_array[0]) ? $new_marker_array[0] : null;
			  $global_markers[$i]['lon'] = !empty($new_marker_array[1]) ? $new_marker_array[1] : null;
			  $global_markers[$i]['desc'] = !empty($new_marker_array[2]) ? $new_marker_array[2] : null;
			  $global_markers[$i]['img'] = !empty($new_marker_array[3]) ? preg_replace("/<br\W*?\/>/", "", $new_marker_array[3]) : null;
			  $global_markers[$i]['visible'] = !empty($new_marker_array[4]) ? $new_marker_array[4] : 'no';
			  $i++;
		  }
		  }
		  
	  }
	  
	  $brad_includes['global_mapData']['map_'.$map_id] =  $global_markers;
	 }
		
	 if( $address != ''){
		 $coordinates = get_gmap_coordinates($address);
		 if( is_array($coordinates) && !empty($coordinates['lat']) ){
			 $lat = $coordinates['lat'];
			 $lon = $coordinates['lng'];
		 }
		 elseif( is_string($coordinates) ){
			 $output .= $coordinates;
		 }
		 
	 }
		   
	  $output.= '<div id="map_' .$map_id . '" style="width:' . $width . ';height:' . $height . '" class="google_map"  data-lat="'.$lat.'" data-lon="'.$lon.'" data-maptype="'.$maptype.'" data-scrollwheel="'.$scrollwheel.'" data-zoom="'. $zoom .'" data-marker="'. $marker .'" data-custom-info="'.$custominfo.'" data-info-bgcolor="'.$bg_color.'" data-info-color="'.$txt_color.'"  data-streetview="'.$streetview.'" data-maptype-control="'.$maptypecontrol.'" data-mappan="'.$mappan.'" data-zoomocontrol="'.$zoomcontrol.'" data-zoomsize="'.$zoomsize.'" data-style="'.$style.'"  data-color="'.$brad_data['color_primary'].'" ></div>';

	  
	  $brad_includes['load_gmap'] = true;
	  
	  echo $output;
