<div class="modal fade" id="deleteServerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-deleteServer" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel-deleteServere">Delete Server</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="deleteServerForm">
                <div class="modal-body">
                    Are you sure to delete this Server?
                    <input type="hidden" id="deleteServerId">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="deleteServerBtn" class="btn btn-primary">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
