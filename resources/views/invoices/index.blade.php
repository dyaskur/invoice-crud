@extends("layout")

@section("style")

@endsection
@section("wrapper")

    <div class="container">
        <table id="invoicesTable" class="table table-striped" style="width:100%">
            <thead>
            <tr>
                <th>Invoice Number</th>
                <th>Subject</th>
                <th>Issue Data</th>
                <th>Due Date</th>
                <th>Items</th>
                <th>Subtotal</th>
                <th>Tax Amount</th>
                <th>Total Payment</th>
                <th>Amount Due</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

@endsection

@section("script")
    <script>
      $(document).ready(function () {
        $('#invoicesTable').DataTable({
          processing: true,
          serverSide: true,
          // responsive: true,
          lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All']
          ],
          ajax: "{{ route('invoices.json') }}",
          columns: [
            {data: 'invoice_number', name: 'invoice_number'},
            {data: 'subject', name: 'subject'},
            {data: 'issue_date', name: 'issue_date'},
            {data: 'due_date', name: 'due_date'},
            {
              data: 'items', name: 'items', orderable: false, searchable: false, render: function (data, type, row) {
                return data.length
              }
            },
            {data: 'sub_total', name: 'sub_total', render: $.fn.dataTable.render.number(',', '.', 2, '$')},
            {
              data: 'tax_amount', name: 'tax_amount', render: function (data, type, row) {
                return $.fn.dataTable.render.number(',', '.', 2, '$').display(data, type, row) + ' (' + row.tax_percentage + '%)'
              }
            },
            {data: 'total_payment', name: 'total_payment', render: $.fn.dataTable.render.number(',', '.', 2, '$')},
            {data: 'amount_due', name: 'amount_due', render: $.fn.dataTable.render.number(',', '.', 2, '$')},
            {data: 'action', name: 'action', orderable: false, searchable: false, class: 'right-align'}
          ]
        })
      })

      function destroyData (id) {
        Swal.fire({
          title: 'Are you sure?',
          text: 'You won\'t be able to revert this!',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $('#deleteData').attr('action', window.location.href + '/' + id)
            $('#deleteData').submit()
            Swal.fire(
              'Deleted!',
              'Your file has been deleted.',
              'success'
            )
          } else {
          }
        })
      }
    </script>
    <form method="post" action="" style="display: none" id="deleteData">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
    </form>
@endsection
