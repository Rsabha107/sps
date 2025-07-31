@extends('cms.admin.layout.admin_template')
@section('main')
<!-- ===============================================-->
<!--    Main Content-->
<!-- ===============================================-->

{{-- <div class="content"> --}}
{{-- <div class="container-fluid"> --}}
<div class="d-flex justify-content-between m-2">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}"><?= get_label('home', 'Home') ?></a>
                </li>
                <li class="breadcrumb-item active">
                    <?= get_label('service_period', 'Service Periods') ?>
                </li>
            </ol>
        </nav>
    </div>
    <div>
        <x-button_insert_modal bstitle='Add Event' bstarget="#create_service_period_modal" />
    </div>
</div>
<x-cms.settings.service-period-card />
{{-- </div> --}}

@include('cms.setting.modals.service_period_modals')

<script>
    var label_update = '<?= get_label('update', 'Update') ?>';
    var label_delete = '<?= get_label('delete', 'Delete') ?>';
    var label_not_assigned = '<?= get_label('not_assigned', 'Not assigned') ?>';
    var label_duplicate = '<?= get_label('duplicate', 'Duplicate') ?>';
</script>
<script src="{{ asset('assets/js/pages/cms/service_period.js') }}"></script>
@endsection

@push('script')
<script>
    // showing the offcanvas for the task creation
    $(document).ready(function() {
        console.log('ready');
        $('.dropify').dropify();

    });
</script>
@endpush