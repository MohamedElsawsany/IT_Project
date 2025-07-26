<div class="modal fade" id="deleteSiteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-delete" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel-delete">Delete Site</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="deleteSiteForm">
                <div class="modal-body">
                    Are you sure to delete <span style="color: red;" id="deleteSiteName"></span>?
                    <input type="hidden" id="deleteSiteID">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="deleteSiteBtn" class="btn btn-primary">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
