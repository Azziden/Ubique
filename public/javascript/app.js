function addRowMagazine() {
    // Get the table from the document
    const table = document.getElementById('table');
    const rowCount = table.rows.length;

    // Get how many cells has first row to add same amount on the new row
    const cellCount = table.rows[0].cells.length;

    // -1 to ignore the header row
    const row = table.insertRow(rowCount - 1);

    row.id = `row_${rowCount - 1}`;

    for (var i = 0; i < cellCount; i++) {
        // We get the similar cell from the header row
        let input = createInput(table.rows[0].cells[i]);

        let cell = row.insertCell(i);

        cell.appendChild(input);
        cell.style.backgroundColor = "#373b3e";
    }

}

function createInput(parentCell) {
    let input = document.createElement('input');

    input.classList.add('row-input');
    input.placeholder = 'Écrire';
    input.style.width = parentCell.clientWidth - 25 + 'px';

    input.onfocus = displayTooltip;
    input.oninput = displayTooltip;

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