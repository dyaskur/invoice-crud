@extends("layout")

@section("style")

@endsection
@section("wrapper")

    <div class="container">
        <table id="invoicesTable" class="table table-striped" style="width:100%">
            <thead>
            <tr>
                <th width="7%">Invoice Number</th>
                <th>Subject</th>
                <th>Issue Data</th>
                <th>Due Date</th>
                <th>Items</th>
                <th>Subtotal</th>
                <th>Tax Amount</th>
                <th>Total Payment</th>
                <th>Amount Due</th>
                <th>Status</th>
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
            {
              data: 'status', name: 'status', render: function (data, type, row) {
                return ` <select onchange="updateStatus(this,${row.id})" name="status" class="form-select">
                                                <option ${data === 'draft' ? 'selected' : ''} value="draft">draft</option>
                                                <option ${data === 'paid' ? 'selected' : ''}  value="paid">paid</option>
                                                <option ${data === 'canceled' ? 'selected' : ''} value="canceled">canceled</option>
                                            </select>`
              }
            },
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

      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
      })

      function updateStatus (e, id) {
        const data = {'status': e.value, '_method': 'PATCH'}
        $.ajax({
          type: 'POST',
          url: '/invoices/' + id,
          // The key needs to match your method's input parameter (case-sensitive).
          data: JSON.stringify(data),
          contentType: 'application/json; charset=utf-8',
          dataType: 'json',
          success: function (data) {
            Swal.fire(
              'Updated to ' + e.value,
              'The invoice has been updated.',
              'success'
            )
          },
          error: function (error) {
            console.log(error)
            if (error.responseJSON.message)
              alert(error.responseJSON.message)
            else
              alert('unknown error')
          }
        })
      }
        {!! session('message')?
" Swal.fire(
              '".session('message')."',
            )"
:''!!}
    </script>
    <form method="post" action="" style="display: none" id="deleteData">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
    </form>
@endsection
