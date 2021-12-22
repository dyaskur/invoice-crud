@extends("layout")

@section("style")
    <style>
        .number-input::-webkit-inner-spin-button,
        .number-input::-webkit-outer-spin-button {
            opacity: 1;
        }

        .number-input {
            width: 45px;
        }

        .hidden {
            display: none;
        }
    </style>
@endsection
@section("wrapper")

    <div class="page-wrapper">
        <div class="page-content">

            <div class="row">
                <div class="col-xl-9 mx-auto">
                    <div class="card border-top border-0 border-4 border-info">
                        <div class="card-body">
                            <div class="border p-4 rounded">
                                <div class="card-title d-flex align-items-center">
                                    <div><i class="bx bxs-user me-1 font-22 text-info"></i>
                                    </div>
                                    <h5 class="mb-0 text-info">Create New Invoice </h5>
                                </div>
                                <hr/>


                                <form class="row" method="POST" action="{{route("invoices.store")}}">
                                    {{csrf_field()}}
                                    <div class="row mb-3">
                                        <label for="inputEnterYourName" class="col-sm-3 col-form-label">Subject</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control @error('subject') is-invalid @enderror"
                                                   id="inputEnterYourName" name="subject" value="{{old('subject')}}"
                                                   placeholder="Enter the Name" required>

                                            @error('subject')
                                            <div class="invalid-feedback" category="alert"><strong>{{ $message }}</strong>
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="slug" class="col-sm-3 col-form-label">
                                            Issue Date</label>
                                        <div class="col-sm-9">
                                            <input type="date" class="form-control @error('issue_date') is-invalid @enderror"
                                                   id="issue_date" name="issue_date"
                                                   value="{{old('issue_date')}}" placeholder="Enter the Issue date" required>
                                            @error('issue_date')
                                            <div class="invalid-feedback" category="alert"><strong>{{ $message }}</strong>
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="slug" class="col-sm-3 col-form-label">
                                            Due Date</label>
                                        <div class="col-sm-9">
                                            <input type="date" class="form-control @error('due_date') is-invalid @enderror"
                                                   id="due_date" name="due_date"
                                                   value="{{old('due_date')}}" placeholder="Enter the Due date" required>
                                            @error('due_date')
                                            <div class="invalid-feedback" category="alert"><strong>{{ $message }}</strong>
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="issued_by" class="col-sm-3 col-form-label">
                                            Issued by</label>
                                        <div class="col-sm-9">

                                            <select id="issued_by" name="issued_by" class="form-select">
                                                <option selected disabled>Choose...</option>
                                                @foreach($companies as $user)
                                                    <option value="{{$user->id}}">{{$user->name}}({{$user->country->name}})</option>
                                                @endforeach
                                            </select>
                                            @error('issued_by')
                                            <div class="invalid-feedback" role="alert"><strong>{{ $message }}</strong>
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="issued_for" class="col-sm-3 col-form-label">
                                            Issued For</label>
                                        <div class="col-sm-9">

                                            <select id="issued_for" name="issued_for" class="form-select">
                                                <option selected disabled>Choose...</option>
                                                @foreach($companies as $user)
                                                    <option value="{{$user->id}}">{{$user->name}}({{$user->country->name}})</option>
                                                @endforeach
                                            </select>
                                            @error('issued_for')
                                            <div class="invalid-feedback" role="alert"><strong>{{ $message }}</strong>
                                            </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <table id="itemList" class="table table-striped" style="width:100%">
                                            <thead>
                                            <tr>
                                                <th>Item Name</th>
                                                <th>Item Type</th>
                                                <th width="4%">Quantity</th>
                                                <th>Price</th>
                                                <th>Amount</th>
                                                <th width="4%"></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr class="item_row">
                                                <td>
                                                    <select name="products[0][item_id]" class="item_id_input" onchange="updatePrice(this)">
                                                        <option selected disabled>Choose...</option>
                                                        @foreach($items as $item)
                                                            <option value="{{$item->id}}" data-price="{{$item->price}}"
                                                                    data-type="{{$item->itemType?->name}}">{{$item->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="item_type_col"></td>
                                                <td><input name="products[0][quantity]" value="1" type="number" disabled
                                                           class="quantity_input number-input"
                                                           onchange="updatePrice(this)" min="1"></td>
                                                <td class="item_price_col"></td>
                                                <td class="item_total_col"></td>
                                                <td><a class="btn btn-xs px-0 py-0 remove_item_row hidden"
                                                       onclick="removeItem(this)" title="Delete item"><i class="bi-trash"
                                                                                                         style="font-size: 1rem; color: red;"></i></a>
                                                </td>
                                            </tr>
                                            <tr id="addMoreRow">
                                                <td colspan="6" onclick="addMoreItem()">
                                                    <button type="button">add more item</button>
                                                </td>
                                            </tr>

                                            <tr class="summary_row">
                                                <td></td>
                                                <td class="item_type_col"></td>
                                                <td></td>
                                                <td class="item_price_col">SubTotal</td>
                                                <td id="subtotalPrice" class="">$0</td>
                                                <td></td>
                                            </tr>
                                            <tr class="summary_row">
                                                <td></td>
                                                <td class="item_type_col"></td>
                                                <td></td>
                                                <td class="item_price_col">Tax Percentage</td>
                                                <td class="">
                                                    <input name="tax_percentage" value="10" type="number" class="number-input"
                                                           onchange="updateTotal()" id="taxPercent" min="0" max="100">%
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr class="summary_row">
                                                <td></td>
                                                <td class="item_type_col"></td>
                                                <td></td>
                                                <td class="item_price_col">Tax Amount</td>
                                                <td id="totalTax" class="">$0</td>
                                                <td></td>
                                            </tr>
                                            <tr class="summary_row">
                                                <td></td>
                                                <td class="item_type_col"></td>
                                                <td></td>
                                                <td class="item_price_col">Amount Total</td>
                                                <td id="totalPrice" class="">$0</td>
                                                <td></td>
                                            </tr>
                                            <tr class="summary_row">
                                                <td></td>
                                                <td class="item_type_col"></td>
                                                <td></td>
                                                <td class="item_price_col">Total Payment</td>
                                                <td class="">
                                                    <input name="total_payment" value="0" type="number" class="number" style="width: 100px"
                                                           onchange="updateTotal()" id="totalPayment">
                                                </td>
                                                <td></td>
                                            </tr>

                                            <tr class="summary_row">
                                                <td></td>
                                                <td class="item_type_col"></td>
                                                <td></td>
                                                <td class="item_price_col">Amount due</td>
                                                <td id="amountDue" class="">$0</td>
                                                <td></td>
                                            </tr>


                                            </tbody>
                                            <tfoot>
                                            </tfoot>
                                        </table>

                                    </div>
                                    <div class="row">
                                        <label class="col-sm-3 col-form-label"></label>
                                        <div class="col-sm-9">
                                            <button type="submit" class="btn btn-info px-5" disabled>Create a new invoice</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end row-->
        </div>
    </div>

@endsection

@section("script")
    <script>
      var counter = 0
      $(document).ready(function () {
      })

      function addMoreItem () {
        counter++
        var $row = $('#itemList').find('tbody').children('tr:first')
        var $clone = $row.clone()
        $clone.find('.item_type_col').html('')
        $clone.find('.item_price_col').html('')
        $clone.find('.item_total_col').html('')
        $clone.find('.hidden').removeClass('hidden')
        updatePrice($clone)
        $('#addMoreRow').before($('<div>').append($clone).html().replaceAll('products[0]', 'products[' + counter + ']'))
        console.log($row)
      }

      function updatePrice ($this) {
        const parent = $($this).closest('.item_row')
        const item = parent.find('select')
        const item_id = item.val()
        if (!item_id) {
          parent.find('.quantity_input').attr('disabled', true)
        } else {
          parent.find('.quantity_input').removeAttr('disabled')
        }
        const price = item.find(':selected').data('price')
        const type = item.find(':selected').data('type')
        const quantity = parent.find('.quantity_input').val()
        const total = price * ~~quantity
        parent.find('.item_type_col').html(type)
        parent.find('.item_price_col').html(price)
        parent.find('.item_total_col').html(parseFloat(total || 0).toFixed(2))
        updateTotal()
      }

      function updateTotal () {
        const total = $('#itemList').find('tbody').find('tr').map(function () {
          return $(this).find('.item_total_col').html() || 0
        }).get()
        const sub_total = total.reduce(function (a, b) {
          console.log(a, b, 'z')
          a = a || 0
          b = b || 0
          console.log(a, b)
          return parseFloat(a) + parseFloat(b)
        }, 0)
        $('#subtotalPrice').html(parseFloat(sub_total).toFixed(2))
        const tax = $('#taxPercent').val()
        const total_payment = $('#totalPayment').val()
        const tax_amount = parseFloat(sub_total * tax / 100)
        const amount_total = parseFloat(sub_total + tax_amount).toFixed(2)
        const amount_due = parseFloat(total_payment - amount_total).toFixed(2)
        $('#totalTax').html(tax_amount.toFixed(2))
        $('#totalPrice').html(amount_total)
        $('#amountDue').html(amount_due)
        if (sub_total > 0) {
          $('button[type="submit"]').removeAttr('disabled')
        } else {
          $('#subtotalPrice').html('Please select all items first')
          $('#totalPrice').html('Please select all items first')
          $('button[type="submit"]').attr('disabled', 'disabled')
        }
      }

      function removeItem ($this) {
        const parent = $($this).closest('.item_row')
        parent.remove()
      }
    </script>
@endsection
