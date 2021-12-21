@extends("layout")

@section("style")

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
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                   id="inputEnterYourName" name="name" value="{{old('name')}}"
                                                   placeholder="Enter the Category Name" required>

                                            @error('name')
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
                                                @foreach($users as $user)
                                                    <option value="{{$user->id}}">{{$user->name}}</option>
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
                                                @foreach($users as $user)
                                                    <option value="{{$user->id}}">{{$user->name}}</option>
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
                                                <th>Quantity</th>
                                                <th>Price</th>
                                                <th>Amount</th>
                                                <th width="4%"></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <select name="products[0][item_id]">
                                                        <option selected disabled>Choose...</option>
                                                        @foreach($users as $user)
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td></td>
                                                <td><input name="products[0][qty]" type="number"></td>
                                                <td></td>
                                                <td></td>
                                                <td><a class="btn btn-xs  px-0 py-0"
                                                       onclick="destroyData()" title="Delete item"><i class="bi-trash"
                                                                                                  style="font-size: 1rem; color: red;"></i></a>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="6">
                                                    <button>add more item</button>
                                                </td>
                                            </tr>
                                            </tbody>
                                            <tfoot>
                                            </tfoot>
                                        </table>

                                    </div>

                                    {{--                                    <div class="row mb-3">--}}
                                    {{--                                        <label for="status" class="col-sm-3 col-form-label">--}}
                                    {{--                                            Status</label>--}}
                                    {{--                                        <div class="col-sm-9">--}}

                                    {{--                                            <select id="status" name="is_active" class="form-select">--}}
                                    {{--                                                --}}{{--                                                <option selected disabled>Choose...</option>--}}
                                    {{--                                                <option value="1">Active</option>--}}
                                    {{--                                                <option value="0" @if(old('is_active') === '0') selected @endif>Inactive--}}
                                    {{--                                                </option>--}}
                                    {{--                                            </select>--}}

                                    {{--                                            @error('status')--}}
                                    {{--                                            <div class="invalid-feedback" category="alert"><strong>{{ $message }}</strong>--}}
                                    {{--                                            </div>--}}
                                    {{--                                            @enderror--}}
                                    {{--                                        </div>--}}
                                    {{--                                    </div>--}}
                                    <div class="row">
                                        <label class="col-sm-3 col-form-label"></label>
                                        <div class="col-sm-9">
                                            <button type="submit" class="btn btn-info px-5">Create</button>
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
      $(document).ready(function () {
        $('#example').DataTable()
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
@endsection
