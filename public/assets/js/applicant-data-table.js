$(document).ready(function(){
    const dataTableBasic = new simpleDatatables.DataTable("#applicant-data-table", {
        searchable: false,
        fixedHeight: true,
        perPage: 10
    });
    // $('#search-input').on('input', function() {
    //     dataTableBasic.search($(this).val()).draw();
    //   });
      $(".dataTable-input").hide()

  });