<?php

/**
 * author gusto(watonist@telkom.net)
 */
class ResultSet{
  var $_arrayHolder = array();
  var $_key = array();

  var $_currentIndex = 0;

  function setHolder($result){
    $this->_arrayHolder = $result;
    array_change_key_case($this->_arrayHolder, CASE_UPPER);
    $this->_key = array_keys($this->_arrayHolder);
    $this->reset();
  }

  function size(){
    if($this->columnSize() > 0){
      return count($this->_arrayHolder[$this->_key[0]]);
    }else{
      return 0;
    }
  }

  function columnSize(){
    return count($this->_arrayHolder);
  }

  function fieldName($column){
    $upperKey = strtoupper($column);

    if(array_key_exists($upperKey, $this->_arrayHolder)){
      return $upperKey;
    }

    if($column < $this->columnSize()){
      if(array_key_exists($column, $this->_key)){
        $keyColumn = $this->_key[$column];
        if(array_key_exists($keyColumn, $this->_arrayHolder)){
          return $keyColumn;
        }
      }
    }else return NULL;
  }

  function columnName($column){
    $this->fieldName($column);
  }

  function get(){
    $argsNum = func_num_args();
    if($argsNum <= 0) return;

    if($argsNum == 1){
      $column = func_get_arg(0);
      $index = $this->_currentIndex;
    }else if($argsNum == 2){
      $index = func_get_arg(0);
      $column = func_get_arg(1);
    }

    $key = $this->fieldName($column);
    if($key != NULL){
      if(array_key_exists($key, $this->_arrayHolder)){
        return $this->_arrayHolder[$key][$index];
      }
    }
  }

  function reset(){
    $this->_currentIndex = -1;
  }

  function last(){
    $this->_currentIndex = $this->size();
  }

  function next(){
    $this->_currentIndex++;
    if($this->_currentIndex >= $this->size()) return false;

    return true;
  }

  function previous(){
    $this->_currentIndex--;
    if($this->_currentIndex < 0) return false;

    return true;
  }
}
?>