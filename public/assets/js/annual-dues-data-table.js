$(document).ready(function(){
    const dataTableBasic = new simpleDatatables.DataTable("#annual-dues-table", {
        searchable: true,
        fixedHeight: true,
        perPage: 10
    });
    $('#search-input').on('input', function() {
        dataTableBasic.search($(this).val()).draw();
      });
      $(".dataTable-top").hide()
  });

