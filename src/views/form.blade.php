
{{-- Generating form from App\Forms\CountryForm.php --}}
{!! form_start($form) !!}
{!! form_until($form, 'flag') !!}
<div class="col-md-12">
    {!! form_until($form, 'clear') !!}
</div>
{!! form_rest($form) !!}
{!! form_end($form, $renderRest = true) !!}
@include('plugins.dropify')
@push('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\CountryRequest') !!}
     <script>
        $(document).ready(function(){
          $('.dropify').dropify();
        });
    </script>
@endpush