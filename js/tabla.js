$(document).ready(function(){
    $("#example").DataTable({
        //destroy: true,
        //lengthChange: false,
        pageLength:10,
        
        lengthMenu:[10,50,100,500],
        // columnDefs:[{orderable: false,target:[0,1,2,3,4,5,6,7,8,9,10,12,13,14,15,16,17,18,19,20]},
        
        // ],
        language: {
             "url":"https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json",
        },
        order: [[0, 'desc']],    
        //dom: 'Bfrtip',
        //buttons: [ 'copy', 'excel', 'pdf', 'colvis' ],
    });
    });
    $(document).ready(function(){
        $("#nota").DataTable({
            //destroy: true,
            //lengthChange: false,
            pageLength:10,
            
            lengthMenu:[10,50,100,500],
            columnDefs: [
                {orderable: false, target: [0,1,2,3,4,5,6,7,8,9,10,,11,12,13,14,15]},
                {serchable: false, target: [2,3,4,5,6,7,8,9,10,11,12,13,14,15]}            
            ],
            language: {
                 "url":"https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json",
            },
            order: [[0, 'asc']],    
            //dom: 'Bfrtip',
            //buttons: [ 'copy', 'excel', 'pdf', 'colvis' ],
        });
        });
        
    