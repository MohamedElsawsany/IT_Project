<div class="modal fade" id="deleteModemModal" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel-deleteModem" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel-deleteModem">Delete Modem</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="deleteModemForm">
                <div class="modal-body">
                    Are you sure to delete this Modem?
                    <input type="hidden" id="deleteModemId">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="deleteModemBtn" class="btn btn-primary">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
