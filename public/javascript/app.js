function addRowInTable(table_body) {




}


function create_tr(table_id) {
    let table_body = document.getElementById(table_id),
        first_tr = table_body.firstElementChild
    tr_clone = first_tr.cloneNode(true);

    table_body.append(tr_clone);





}