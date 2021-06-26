<?php
namespace App\Helpers;

class TableHelper {


    /**
    * Obtiene el icono de editar con su correspondiente url
    *
    * @param string $url
    * @param integer $id si se envia el parametro redirecciona a otra pagina
    * @param boolean $tooltip
    * @return string
    */
    public static function getIconEdit($url,$id='',$tooltip=true,$modalId='modalForm'){

        $iconEdit = "";

        $codeTooltip = "";

        if($tooltip){
            $codeTooltip = "data-toggle='tooltip'";
        }

        if($id){
            $iconEdit= "<a id='edit-item-{$id}' data-url='".$url."' data-modal-id='".$modalId."' onclick='fg.editModalForm(this);'  class='mr-2 icon-edit-item' >";
        }else{
            $iconEdit= "<a href='".$url."'  class='mr-2'  >";
        }

        $iconEdit .= "<i ".$codeTooltip." title='Editar' class='".config('constant.icon.edit.class')." ".config('constant.icon.edit.color')." fa-2x' ></i>
                            </a>";

        return $iconEdit;
    }

    /**
    * Obtiene el icono de mostrar con su correspondiente url
    *
    * @param string $url
    * @param boolean $tooltip
    * @return string
    */
    public static function getIconShow($url,$tooltip=true){

        $codeTooltip = "";

        if($tooltip){
            $codeTooltip = "data-toggle='tooltip'";
        }

        return "<a href='".$url."'  class='mr-2' ".$codeTooltip." title='Ver detalle' >
                        <i   class='".config('constant.icon.show.class')." ".config('constant.icon.edit.color')." fa-2x' ></i>
                    </a>";
    }

    /**
    * Obtiene el icono de borrar con su correspondiente url
    *
    * @param string $url
    * @param integer $id
    * @param boolean $tooltip
    * @return string
    */
    public static function getIconRemove($url,$id,$tooltip=true){
        $codeTooltip = "";

        if($tooltip){
            $codeTooltip = "data-toggle='tooltip'";
        }

        return "<a id='delete-item-{$id}' onclick='fg.deleteById(this);'
                            class='delete-item mr-2' data-url='".$url."' data-id='{$id}' >
                    <i class='".config('constant.icon.delete.class')." ".config('constant.icon.delete.color')." fa-2x' ".$codeTooltip." title='Borrar'></i>
                </a>";
    }

    /**
    * Obtiene el checkbox de la fila
    *
    * @param integer $id
    * @return string
    */
    public static function getCheckBoxRow($id){
        return "<div class='custom-control custom-checkbox check-box-row'>
                    <input id='checkbox-{$id}' type='checkbox'  class='custom-control-input' value='{$id}' >
                    <label class='custom-control-label' for='checkbox-{$id}'></label>
                </div>";
    }




}
