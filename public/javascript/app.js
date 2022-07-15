
function addRowMagazine() {
    // Get the table from the document
    const table = document.getElementById('table');
    const rowCount = table.rows.length;

    // Get how many cells has first row to add same amount on the new row
    const cellCount = table.rows[0].cells.length;

    // -1 to ignore the header row
    const row = table.insertRow(rowCount - 1);

    row.id = `row_${rowCount - 1}`;
    row.setAttribute('data-new', true);

    let collapsingTo;
    let inputCollapsingTo;

    for (var i = 0; i < cellCount; i++) {
        const headCell = table.rows[0].cells[i];

        // We get the similar cell from the header row
        let input = createInput(headCell);

        collapsingTo = headCell.getAttribute("data-collapse-to");

        if (collapsingTo) {
            row.cells[parseInt(collapsingTo)].colSpan++;

            inputCollapsingTo.style.width = inputCollapsingTo.clientWidth + headCell.clientWidth + "px";
        } else {
            inputCollapsingTo = input;

            if (i == 0) {
                enableAutocomplete(input);
            } else {
                input.disabled = true;
            }

            let cell = row.insertCell(row.cells.length);

            cell.appendChild(input);
            cell.style.backgroundColor = "#373b3e";
        }

    }

}

function createInput(parentCell) {
    let input = document.createElement('input');


    input.classList.add('row-input');
    input.placeholder = 'Écrire';
    input.style.width = parentCell.clientWidth - 16 + 'px';

    input.onfocus = displayTooltip;
    input.oninput = displayTooltip;
    input.onblur = () => setTooltipVisible(false);


    return input;
}

function displayTooltip(e) {
    // We check whether the content of the input is empty
    if (e.target.value.trim() === '') {
        setTooltipVisible(false);

        return;
    }

    setTooltipVisible(true);
    setTooltipPosition(e.target.value, e.target.parentElement);

}

function setTooltipVisible(b) {
    const tooltip = document.getElementById('edit-tooltip');

    if (b) {
        tooltip.style.display = 'block';
    } else {
        tooltip.style.display = 'none';
        tooltip.innerText = null;
    }
}

function setTooltipPosition(content, parentTd) {
    const tooltip = document.getElementById('edit-tooltip');

    // Set the tooltip content to the input value
    tooltip.innerText = content;

    // Get the id from the cell (<td>) and split it by _ getting index number 1; example: row_5 => 5
    const row = parseInt(parentTd.parentElement.id.split('_')[1]) - 1;

    // Knowing that every row has 41 height, we multiply the position of the row by 41, adding it 35 (being 41 - half of the tooltip arrow)
    const top = 35 + (41 * row);

    // parentTd.offsetLeft = how far from the left is the current cell
    const left = parentTd.offsetLeft + parentTd.clientWidth / 2 - tooltip.clientWidth / 2;

    tooltip.style.top = top + 'px';
    tooltip.style.left = left + 'px';
}

const addRow = document.getElementById('add_row');

if (addRow) {
    addRow.onclick = () => addRowMagazine();
}

function enableAutocomplete(e) {
    let results;

    $(e).autocomplete({
        source: function (query, cb) {
            $.ajax({
                url: $('#autocomplete-url')[0].value + '?query=' + query.term
            }).then(function (data) {
                results = data;

                cb(results.map(i => i.nom_d_usage));
            });
        },
        debounce: 300, // only request every 1/2 second
        select: function (event, ui) {
            event.target.parentElement.style.backgroundColor = null;
            event.target.disabled = true;

            let selected;

            for (const r of results) {
                if (r.nom_d_usage === ui.item.label) {
                    selected = r;

                    break;
                }
            }

            event.target.parentElement.parentElement.setAttribute('data-id', selected.id);

            const cell = event.target.parentElement;
            const headCells = cell.parentElement.parentElement.parentElement.rows[0].cells;

            const filledIdx = cell.cellIndex;
            const filledWidth = headCells[filledIdx].clientWidth;

            let cellIdx = filledIdx;

            for (let i = 0; i < headCells.length; i++) {
                const headCell = headCells[i];

                const key = headCell.getAttribute("data-column");
                const collapseTo = headCell.getAttribute("data-collapse-to");

                if (selected.hasOwnProperty(key) && collapseTo == filledIdx) {
                    const createdCell = cell.parentElement.insertCell(++cellIdx);

                    const input = createInput(headCell);

                    input.disabled = true;

                    createdCell.appendChild(input);

                    input.value = selected[key];
                    input.placeholder = "";
                } else {
                    cell.parentElement.cells[i].children[0].disabled = false;
                }
            }

            event.target.style.width = filledWidth + "px";
            cell.colSpan = 1;

            setTooltipVisible(false);
        }
    })
}

$("#data-form").on('submit', function (e) {
    const newTableData = [];

    e.preventDefault();

    const table = document.getElementById('table');

    for (const row of table.rows) {
        let dataId = row.getAttribute('data-id');

        if (row.getAttribute('data-new') && dataId !== null) {
            const rowData = {
                salarie_id: parseInt(dataId),
            };

            for (const cell of row.cells) {
                const headCell = table.rows[0].cells[cell.cellIndex];
                const name = headCell.getAttribute('data-name');

                if (name) {
                    if (validateInput(cell.children[0], headCell)) {
                        rowData[name] = parseInputValue(cell.children[0], headCell);
                    } else {
                        alert('Erreur de saisie');

                        return;
                    }
                }
            }

            newTableData.push(rowData);
        }
    }

    if (newTableData.length === 0) {
        return;
    }

    document.getElementById('data-input').value = JSON.stringify(newTableData);

    e.target.submit();
})

function validateInput(input, headCell) {
    const isRequired = headCell.getAttribute("data-required");
    const type = headCell.getAttribute("data-type");
    const maxLength = headCell.getAttribute("data-max-length");

    if (isRequired && input.value === '') {
        return false;
    }

    if ((!isRequired && input.value !== '') || isRequired) {
        switch (type) {
            case 'string':
                break;
            case 'int':
                if (!Number.isInteger(parseFloat(input.value))) {
                    return false;
                }
            case 'double':
                if (Number.isNaN(parseFloat(input.value))) {
                    return false;
                }
        }
    }

    if ((!isRequired && input.value !== '') || isRequired) {
        if (maxLength !== null && input.value.length > parseInt(maxLength)) {
            return false;
        }
    }

    return true;
}

function parseInputValue(input, headCell) {
    const type = headCell.getAttribute("data-type");

    switch (type) {
        case 'string':
            return input.value;
        case 'int':
            return parseInt(input.value);
        case 'double':
            return parseFloat(input.value);
    }

    return null;
}

function montantCalculator(){


}