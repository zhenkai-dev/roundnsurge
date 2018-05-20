<div id="modalDelete" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalDelete" aria-hidden="true">
    <div class="modal-dialog modal-danger" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this record? This action cannot be undo.</p>
            </div>
            <div class="modal-footer">
                <form action="" method="post">
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}

                    <button type="submit" class="btn btn-primary" data-loading-text="<i class='fa fa-spinner fa-pulse'></i> Loading...">Delete now</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>