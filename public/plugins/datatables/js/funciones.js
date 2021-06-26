// Updates "Select all" control in a data table
function inicializarCheckBox(idTable){
    // console.log("nuevo 1")
    if(fg.isEmpty(idTable)){
        idTable = ".table";
    }

    // Handle click on "Select all" control
    $(' thead .checkbox-table,tfoot .checkbox-table',$(idTable)).on('click', function(e){
        // console.log("click")
        $('input[type="checkbox"]',$(idTable)).prop("checked",this.checked);

        // Prevent click event from propagating to parent
        e.stopPropagation();
    });


    let dataTable =$(idTable).DataTable();

    // Handle table draw event
    dataTable.on('draw', function(){
        // Update state of "Select all" control
        updateDataTableSelectAllCtrl(dataTable);
    });

}



function updateDataTableSelectAllCtrl(dataTable){
    // console.log("updateDataTableSelectAllCtrl");
    var $table             = dataTable.table().node();
    var $chkbox_all        = $('tbody [type="checkbox"]', $table);
    var $chkbox_checked    = $('tbody input[type="checkbox"]:checked', $table);
    var chkbox_select_all  = $('thead .checkbox-table', $table).get(0);
    var chkbox_table_foot  = $('tfoot .checkbox-table', $table).get(0);


    // console.log(chkbox_table_foot);
    // If none of the checkboxes are checked
    if($chkbox_checked.length === 0){
        chkbox_select_all.checked = false;
        chkbox_table_foot.checked = false;
        if('indeterminate' in chkbox_select_all){
            chkbox_select_all.indeterminate = false;
        }

        // If all of the checkboxes are checked
    } else if ($chkbox_checked.length === $chkbox_all.length){
        chkbox_select_all.checked = true;
        chkbox_table_foot.checked = true;
        if('indeterminate' in chkbox_select_all){
            chkbox_select_all.indeterminate = false;
        }

        // If some of the checkboxes are checked
    } else {
        chkbox_select_all.checked = true;
        chkbox_table_foot.checked = true;
        if('indeterminate' in chkbox_select_all){
            chkbox_select_all.indeterminate = true;
        }
    }
}

function widthAdjust(){
    $($.fn.dataTable.tables(true)).DataTable()
        .columns.adjust();
}

/*
* Obtiene los botones por defecto para exportar
*
* @param string title
* @param array columnsExport
* @return void
*/
function getDefaultExportButtons(title="Reporte",columnsExport=[])
{

    if(columnsExport.length === 0){
        columnsExport = ":visible"
    }

    return [
        {
            extend: 'excel',
            title: title,
            text: '<i class="far fa-file-excel"></i> Excel',
            className: 'btn btn-excel',
            filename: function(){
                return generateNameDocument(title)
            },
            exportOptions: {
                columns: columnsExport
            },
        }
    ];
}

function generateNameDocument(title)
{
    let today = new Date();
    let date = today.getDate()+'-'+(today.getMonth()+1)+'-'+today.getFullYear();
    let time = today.getHours() + "-" + today.getMinutes() + "-" + today.getSeconds();
    let dateTime = date+'-'+time;
    return title+"-"+dateTime;
}


/*
* Trae el total de una columna de la tabla
*
* @param array,integer
* @return string
*/

function getTotalTable(api,column,numberDecimals=""){
    let text = "";
    // Remove the formatting to get integer data for summation
    var intVal = function ( i ) {
        return typeof i === 'string' ?
            i.replace(/[\$,]/g, '')*1 :
            typeof i === 'number' ?
                i : 0;
    };

    // // Total over all pages
    var dataTotal = api
        .column( column )
        .data();

    var dataPageTotal = api
        .column( column, { page: 'current'} )
        .data();

    if(dataTotal.length > 0 && dataPageTotal.length > 0){
        // Total over all pages
        var total = dataTotal
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            } );

        // Total over this page
        var pageTotal = dataPageTotal
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            } );
        if(numberDecimals === ""){
            text = pageTotal +' ( '+total +' Total )';
        }else{
            text = parseFloat(pageTotal).toFixed(numberDecimals) +' ( '+parseFloat(total).toFixed(numberDecimals) +' Total )';
        }
    }

    return {pageTotal:pageTotal,total:total,text:text};
}

let datatableFunc = {};

datatableFunc =  {
    inicializarCheckBox,
    updateDataTableSelectAllCtrl,
    widthAdjust,
    getDefaultExportButtons,
    getTotalTable,
}


export default datatableFunc
