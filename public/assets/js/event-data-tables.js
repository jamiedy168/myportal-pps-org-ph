$(document).ready(function() {
    const dataTableSearch = new simpleDatatables.DataTable("#datatable-search", {
        searchable: false,
        fixedHeight: false,
        sortable: false,
        perPage: 7,
      });
    
      $('#committee-group-input').on('input', function() {
        dataTableSearch.search($(this).val()).draw();
      });
      $(".dataTable-top").hide()
      $(".dataTable-info").hide()

    
});

