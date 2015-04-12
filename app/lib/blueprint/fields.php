<?php

namespace Blueprint;

use Collection;

class Fields extends Collection {

  public function __construct($fields = array(), $page = null) {

    if(empty($fields) or !is_array($fields)) $fields = array();

    foreach($fields as $name => $field) {
      if($field['type'] == 'import'){
        // Import a blueprint snippet
        foreach(\blueprint::find('snippets' . DS . $field['snippet'])->fields($page) AS $f){
          $this->append($f->name, $f);
        }
        continue;
      }
      
      // add the name to the field
      $field['name'] = $name;
      $field['page'] = $page;

      // creat the field object
      $field = new Field($field);

      // append it to the collection
      $this->append($name, $field);

    }

  }

  public function toArray($callback = null) {
    $result = array();
    foreach($this->data as $field) {
      $result[$field->name()] = $field->toArray();
    }
    return $result;
  }

}
