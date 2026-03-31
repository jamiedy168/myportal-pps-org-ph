$(document).ready(function(){
    const dataTableBasic = new simpleDatatables.DataTable("#choose-member-table", {
        searchable: true,
        fixedHeight: false,
        perPage: 5
    });
    $('#search-input').on('input', function() {
        dataTableBasic.search($(this).val()).draw();
      });

    const annualdues = new simpleDatatables.DataTable("#table_transaction", {
        searchable: true,
        fixedHeight: false,
        perPage: 10
    });
    $('#search-input2').on('input', function() {
        annualdues.search($(this).val()).draw();
      }); 

      $(".dataTable-input").hide()
  });

