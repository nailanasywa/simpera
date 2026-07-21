/**
 * SIMPERA DataTable Helper
 * Refactor from mazer Template
 */

function initDataTable(selector, options = {}) {
    const defaultOptions = {
        responsive: true,
        pagingType: "simple_numbers",
        pageLength: 10,
        lengthMenu: [
            [10, 25, 50, 100],
            [10, 25, 50, 100],
        ],
        dom:
            "<'row'<'col-md-6'l><'col-md-6'f>>" +
            "<'row dt-row'<'col-sm-12'tr>>" +
            "<'row'<'col-md-5'i><'col-md-7'p>>",
        language: {
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Tidak ada data",
            infoFiltered: "(difilter dari _MAX_ data)",
            zeroRecords: "Data tidak ditemukan",
            emptyTable:
                '<div class="py-5">' +
                '<i class="bi bi-folder2-open fs-1 text-secondary"></i>' +
                "<br><br>" +
                '<span class="text-muted">Belum ada data.</span>' +
                "</div>",
            lengthMenu: "Tampilkan _MENU_ data",
            search: "",
            searchPlaceholder: "Cari...",
            paginate: {
                previous: "Sebelumnya",
                next: "Selanjutnya",
            },
        },
    };

    const table = $(selector).DataTable(
        $.extend(true, {}, defaultOptions, options),
    );
    table.on("draw", setTableColor);
    setTableColor();
    return table;
}

function setTableColor() {
    document
        .querySelectorAll(".dataTables_paginate .pagination")
        .forEach(function (item) {
            item.classList.add("pagination-primary");
        });
}
