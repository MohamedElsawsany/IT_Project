<div class="modal fade" id="addMobileSimModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New Mobile Sim</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form autocomplete="off" id="addMobileSimForm">
                <div class="modal-body">
                    <table style="width:100%;" class="table table-borderless nowrap display">
                        <tr>
                            <td style="width:44%;margin: auto;">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-default-mobileSimSerialNumber">Serial.No</span>
                                    </div>
                                    <input type="text" class="form-control col-xs-3" required id="mobileSimSerialNumber"
                                           name="mobileSimSerialNumber" aria-label="Sizing example input"
                                           aria-describedby="inputGroup-sizing-default-mobileSimSerialNumber"
                                           autocomplete="off">
                                </div>
                            </td>
                            <td style="width:6%;margin: auto;">

                            </td>

                            <td style="width:44%;margin: auto;">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-default-mobileSimNumber">Mobile.No</span>
                                    </div>
                                    <input type="text" class="form-control col-xs-3" required id="mobileSimNumber"
                                           name="mobileSimNumber" aria-label="Sizing example input"
                                           aria-describedby="inputGroup-sizing-default-mobileSimNumber"
                                           autocomplete="off">
                                </div>
                            </td>
                            <td style="width: 6%;margin: auto;">

                            </td>
                        </tr>
                        <tr>
                            <td style="width:44%;margin: auto;">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-default-mobileSimIP">IP</span>
                                    </div>
                                    <input type="text" class="form-control col-xs-3" required id="mobileSimIP"
                                           name="mobileSimIP" aria-label="Sizing example input"
                                           aria-describedby="inputGroup-sizing-default-mobileSimIP"
                                           autocomplete="off">
                                </div>
                            </td>
                            <td style="width: 6%;margin: auto;">

                            </td>
                            <td style="width: 44%;margin: auto;">
                                <select required id="mobileSimAssignTo" style="width: 100%" name="mobileSimAssignTo"
                                        class="custom-select form-control">
                                    <option disabled value="0" selected>Select Employee</option>
                                    @foreach($employees as $employee)
                                        <option value="{{$employee->id}}">{{$employee->emp_name}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td style="width: 6%;margin: auto;">

                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" id="addMobileSimBtn" class="btn btn-primary">Save</button>
                </div>
            </form>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
