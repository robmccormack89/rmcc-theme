<?php

/* ajax_live_search

*/
function ajax_live_search() {

  global $configs;
  $context['configs'] = $configs;
  $context['blech'] = 'blech';

  // default data for the response. result gets set to 1 when we have a valid query.
  $data = array(
    'result' => 0,
    'response' => ''
  );

  $query = filter_var($_GET['query'], FILTER_SANITIZE_STRING); // validate the string to remove html or script crap
  $context['query_string'] = $query; // capitalize the query string. escaped on the other end just in case
  $context['result_items'] = null;
  $context['result_items_within'] = null;

  // if query is not empty, lets get stuff using it
  if (!empty($context['query_string'])) {
    
    // get terms data if query is for a term
    if(!empty($configs['live_search_taxes'])){
      foreach ($configs['live_search_taxes'] as $tax) {
        // this check is for when post tags are disabled but post_tag still exists in the config types for blog filters

          $tax_args = array(
            'fields' => 'all',
            'name__like' => $query,
          );
          $tax_items = get_terms($tax, $tax_args);
          if(!empty($tax_items)) $context['result_items'][$tax] = $tax_items; // result_items.category

      }
    }

    // get posts if the query returns results with s=
    if(!empty($configs['live_search_types'])){
      foreach ($configs['live_search_types'] as $type) {

        // posts matching the search query
        $post_args = array(
          'post_type' => $type,
          'post_status' => 'publish',
          's' => $query,
          'posts_per_page' => -1
        );
        //$post_items = new Timber\PostQuery($post_args);
        $post_items = Rmcc\Theme::get_posts($post_args);
        if($post_items->found_posts > 0) $context['result_items'][$type] = $post_items; // result_items.post
        
      }
    }

    // // get posts within any queried terms 
    if(!empty($configs['live_search_types_in_taxes'])){
      foreach ($configs['live_search_types_in_taxes'] as $type) {
        foreach ($configs['live_search_taxes'] as $tax) {
          if(!($configs['disable_post_tags'] && $tax == 'post_tag')){

            $matching_taxes = get_terms(array(
              'taxonomy' => $tax,
              'fields' => 'slugs',
              'name__like' => $query,
            ));
            $types_in_taxes_args = array(
              'post_type' => $type,
              'posts_per_page' => -1,
              'tax_query' => array(
                'relation' => 'AND',
                array(
                  'taxonomy' => $tax,
                  'field' => 'slug',
                  'terms' => $matching_taxes
                ),
              ),
            );
            //$types_in_taxes = new Timber\PostQuery($types_in_taxes_args);
            $types_in_taxes = Rmcc\Theme::get_posts($types_in_taxes_args);
            if($types_in_taxes->found_posts > 0) $context['result_items_within'][$type][$tax] = $types_in_taxes; // result_items_within.post.category

          }
        }
      }
    }

  }

  // compile the data in twig & set
  $data['result'] = 1; // a valid result!! posts or no posts, we will compile the template
  $data['response'] = Rmcc\Theme::compile(array('live_search.twig'), $context);
  //$data['response'] = 'hellooooooo';

  // echo the json_encoded compiled twig template, then kill the function
  echo json_encode($data);                                                              
  die();

}

function _ajax_live_search() {

  global $configs;
  $context['configs'] = $configs;
  $context['blech'] = 'blech';

  // default data for the response. result gets set to 1 when we have a valid query.
  $data = array(
    'result' => 0,
    'response' => ''
  );

  $query = filter_var($_POST['query'], FILTER_SANITIZE_STRING); // validate the string to remove html or script crap
  $context['query_string'] = $query; // capitalize the query string. escaped on the other end just in case

  // if query is not empty, lets get stuff using it
  if (!empty($context['query_string'])) {
    
    // get terms data if query is for a term
    if(!empty($configs['live_search_taxes'])){
      foreach ($configs['live_search_taxes'] as $tax) {
        // this check is for when post tags are disabled but post_tag still exists in the config types for blog filters
        if(!($configs['disable_post_tags'] && $tax == 'post_tag')){
          $tax_args = array(
            'fields' => 'all',
            'name__like' => $query,
          );
          $tax_items = get_terms($tax, $tax_args);
          if(!empty($tax_items)) $context['result_items'][$tax] = $tax_items; // result_items.category
        }
      }
    }

    // // get posts if the query returns results with s=
    // if(!empty($configs['live_search_types'])){
    //   foreach ($configs['live_search_types'] as $type) {

    //     // posts matching the search query
    //     $post_args = array(
    //       'post_type' => $type,
    //       'post_status' => 'publish',
    //       's' => $query,
    //       'posts_per_page' => -1
    //     );
    //     //$post_items = new Timber\PostQuery($post_args);
    //     $post_items = Rmcc\Theme::get_posts($post_args);
    //     if($post_items->found_posts > 0) $context['result_items'][$type] = $post_items; // result_items.category
        
    //   }
    // }

    // // get posts within any queried terms 
    // if(!empty($configs['live_search_types_in_taxes'])){
    //   foreach ($configs['live_search_types_in_taxes'] as $type) {
    //     foreach ($configs['live_search_taxes'] as $tax) {
    //       if(!($configs['disable_post_tags'] && $tax == 'post_tag')){

    //         $matching_taxes = get_terms(array(
    //           'taxonomy' => $tax,
    //           'fields' => 'slugs',
    //           'name__like' => $query,
    //         ));
    //         $types_in_taxes_args = array(
    //           'post_type' => $type,
    //           'posts_per_page' => -1,
    //           'tax_query' => array(
    //             'relation' => 'AND',
    //             array(
    //               'taxonomy' => $tax,
    //               'field' => 'slug',
    //               'terms' => $matching_taxes
    //             ),
    //           ),
    //         );
    //         //$types_in_taxes = new Timber\PostQuery($types_in_taxes_args);
    //         $types_in_taxes = Rmcc\Theme::get_posts($types_in_taxes_args);
    //         if($types_in_taxes->found_posts > 0) $context['result_items_within'][$type][$tax] = $types_in_taxes; // result_items_within.post.category

    //       }
    //     }
    //   }
    // }

    $context['result_items_within'] = false;

  }

  // compile the data in twig & set
  $data['result'] = 1; // a valid result!! posts or no posts, we will compile the template
  $response = Rmcc\Theme::compile(array('live_search_results.twig'), $context);
  $data['response'] = $response;

  // echo the json_encoded compiled twig template, then kill the function
  echo json_encode($data);
  die();

}