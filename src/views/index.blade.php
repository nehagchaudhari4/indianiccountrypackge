@extends('admin.layouts.page')

@section('title', __('Countries'))

@section('breadcrumb')
    <li class="breadcrumb-item active">{{ __('Countries') }}</li>
@endsection

@section('action_buttons')
    {!! addButton(route('admin.countries.create'), __('Add Country')) !!}
@endsection

@section('content')
    {!! $dataGridHtml !!}
@endsection

@include('plugins.bootstrap4-toggle')
@push('scripts')
    <script type="text/javascript">
        /* $('#inic_grid_countries').on('AfterRenderGrid',function(){
            $('.change-status').bootstrapToggle({
                on: 'Active',
                off: 'Inactive'
            })
        }) */

        $(document).on('change','.change-status', function(){
            var id =  $(this).attr('data-id');
            $.ajax({
                url: "{{ route('admin.countries.change_status')}}",
                type: "post",
                data: {"id": id},
                datatype: 'json',
                success: function (response) {
                    SwalAlert(response.status, response.message);
                },
                error: function (response) {
                    SwalAlert(response.status, response.message);
                }
            });
        })
    </script>
@endpush
