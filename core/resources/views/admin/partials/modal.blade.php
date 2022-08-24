{{-- Delete Modal --}}
<!-- sample modal content -->
<div id="delModal" class="delModal modal fade" tabindex="-1" aria-labelledby="delModalLabel" style="display: none;"
    aria-modal="true" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="delModalLabel">Are you sure you want to delete this?</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times" aria-hidden="true"></i></button>
            </div>
            <div class="modal-body">
                <h5 class="font-size-16">Are you sure you want to delete '<span class="delTitle"></span>' ?</h5>
                {{-- <p>.</p> --}}
            </div>
            <div class="modal-footer">
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" id="confirmDelete" class="btn btn-secondary waves-effect"
                        data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger waves-effect waves-light">Delete</button>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.sample modal content -->


{{-- Approving Modal --}}
<!-- sample modal content -->
<div id="aprModal" class="aprModal modal fade" tabindex="-1" aria-labelledby="aprModalLabel" style="display: none;"
    aria-modal="true" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="aprModalLabel">Are you sure?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5 class="font-size-16">Are you sure you want to <span class="aprTitle"></span> ?</h5>
                {{-- <p>.</p> --}}
            </div>
            <div class="modal-footer">
                <form id="approvingForm" method="POST">
                    @csrf
                    <button type="button" id="confirmApproving" class="btn btn-secondary waves-effect"
                        data-bs-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-danger waves-effect waves-light">Yes</button>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.sample modal content -->

