$(document).ready(function(){
    const dataTableBasic = new simpleDatatables.DataTable("#payment-table", {
        searchable: true,
        fixedHeight: true,
        perPage: 10
    });
    $('#searchbox-input').on('input', function() {
        dataTableBasic.search($(this).val()).draw();
      });
      $(".dataTable-top").hide()
  });

