$(document).ready(function(){
    const dataTableBasic = new simpleDatatables.DataTable("#user-data-table", {
        searchable: true,
        fixedHeight: true,
        perPage: 5
    });
    $('#search-input').on('input', function() {
        dataTableBasic.search($(this).val()).draw();
      });
      $(".dataTable-input").hide()

  });

