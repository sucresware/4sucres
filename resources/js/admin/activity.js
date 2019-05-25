var $ = require('jquery');
require('datatables.net-bs4')

// $(document).ready(function () {
//     if (!$("#activity").length) return;

//     $table = $('#activity').DataTable({
//         processing: true,
//         searching: false,
//         lengthChange: false,
//         serverSide: true,
//         iDisplayLength: 15,
//         ajax: '/admin/activity/data',
//         columns: [{
//             data: 'icon',
//             name: 'icon',
//             orderable: false
//         }, {
//             data: 'created_at',
//             name: 'created_at'
//         }, {
//             data: 'description',
//             name: 'description',
//             orderable: false
//         }, {
//             data: 'causer',
//             name: 'causer'
//         }, {
//             data: 'actions',
//             name: 'actions',
//             orderable: false,
//             className: "text-right"
//         }],
//         responsive: true,
//         "aaSorting": [
//             [1, 'desc']
//         ],
//     });
// });
