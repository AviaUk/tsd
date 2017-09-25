function selectOrder(oid, cellCnt) {
    if (lastID) {
        setColors(lastID, '#e7e7d6', '#000000', cellCnt);
    }
    if (lastID == oid) {
        lastID = '';
    } else {
        setColors(oid, '#0000ff', '#ffffff', cellCnt);
        lastID = oid;
    }
}

function setColors(oid, bgClr, textClr, cellCnt) {
    if (!cellCnt) {
        cellCnt = 4;
    }
    var cell;
    for (var i = 1; i <= cellCnt; i++) {
        if (cell = document.getElementById(i + oid)) {
            cell.style.backgroundColor = bgClr;
            cell.style.color = textClr;
        }
    }
}