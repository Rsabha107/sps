<div class="table-responsive scrollbar px-3">
    <table class="table table-sm fs-9 mb-0">
        <thead>
            <tr>
                <th class="sort white-space-nowrap align-middle ps-0 pe-3" scope="col" data-sort="file_name" style="width:20%;">FILE NAME</th>
                <th class="sort white-space-nowrap align-middle ps-0 pe-3" scope="col" data-sort="description" style="width:10%;">DESCRIPTION</th>
                <th class="sort text-end align-middle pe-0 ps-5" scope="col"></th>
            </tr>
        </thead>
        <tbody class="list" id="customer-order-table-body">

            <!-- 'original_file_name' => '<div class="align-middle white-space-wrap fw-bold fs-8 ms-3"><a href="' . asset('/storage/upload/event_files/') . '/' . $op->file_name . '" target="_blank"> ' . $op->original_file_name . '</a></div>', -->


            @foreach ($attachments as $key => $attachment)
            <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                <td class="file_name align-middle white-space-nowrap ps-0"><a class="fw-semibold" target="_blank" href="{{ route('global.file.serve', $attachment->id) }}">{{ $attachment->original_file_name }}</a></td>
                <td class="description align-middle white-space-nowrap ps-0 fw-bold">{{ $attachment->description }}</td>
                <td class="align-middle white-space-nowrap text-end pe-0 ps-5">
                    <div class="btn-reveal-trigger position-static">
                        <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs-10"></span></button>
                        <div class="dropdown-menu dropdown-menu-end py-2">
                            <a class="dropdown-item text-danger" id="delete_file" data-table="order_table" data-id="{{ $attachment->id }}" href="#">Remove</a>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>