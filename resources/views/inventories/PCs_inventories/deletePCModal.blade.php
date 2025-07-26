<div class="modal fade" id="deletePCModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-deleteLaptop" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel-deletePC">Delete PC</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="deletePCForm">
                <div class="modal-body">
                    Are you sure to delete this PC?
                    <input type="hidden" id="deletePCId">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="deletePCBtn" class="btn btn-primary">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
