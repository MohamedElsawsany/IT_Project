<div class="modal fade" id="deliveryToEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-add"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel-add">Delivery To ...</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form autocomplete="off" id="deliveryToEmployeeForm">
                <div class="modal-body">

                    <table>
                        <tr>
                            <td style="width:94%;margin: auto;">
                                <select required id="employeeNumberDelivery" style="width: 100%" name="employeeNumberDelivery"
                                        class="custom-select form-control">
                                </select>
                            </td>
                            <td style="width: 6%;margin: auto;">
                                <button type="button" class="btn btn-outline-primary" data-toggle="modal"
                                        data-target="#addEmployeeModal">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </td>
                        </tr>
                    </table>

                    <input type="hidden" id="accessPointDeliveryId" name="accessPointDeliveryId">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="deliveryToEmployeeBtn" class="btn btn-primary">Delivery</button>
                </div>
            </form>
        </div>
    </div>
</div>
