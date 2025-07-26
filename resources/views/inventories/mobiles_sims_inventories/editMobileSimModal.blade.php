<div class="modal fade" id="editMobileSimModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Mobile Sim</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form autocomplete="off" id="editMobileSimForm">
                <div class="modal-body">
                    <table style="width:100%;" class="table table-borderless nowrap display">
                        <tr>
                            <td style="width:44%;margin: auto;">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-default-upMobileSimSerialNumber">Serial.No</span>
                                    </div>
                                    <input type="text" class="form-control col-xs-3" required id="upMobileSimSerialNumber"
                                           name="upMobileSimSerialNumber" aria-label="Sizing example input"
                                           aria-describedby="inputGroup-sizing-default-upMobileSimSerialNumber"
                                           autocomplete="off">
                                </div>
                            </td>
                            <td style="width:6%;margin: auto;">

                            </td>

                            <td style="width:44%;margin: auto;">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-default-upMobileSimNumber">Mobile.No</span>
                                    </div>
                                    <input type="text" class="form-control col-xs-3" required id="upMobileSimNumber"
                                           name="upMobileSimNumber" aria-label="Sizing example input"
                                           aria-describedby="inputGroup-sizing-default-upMobileSimNumber"
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
                                        <span class="input-group-text" id="inputGroup-sizing-default-upMobileSimIP">IP</span>
                                    </div>
                                    <input type="text" class="form-control col-xs-3" required id="upMobileSimIP"
                                           name="upMobileSimIP" aria-label="Sizing example input"
                                           aria-describedby="inputGroup-sizing-default-upMobileSimIP"
                                           autocomplete="off">
                                </div>
                            </td>
                            <td style="width: 6%;margin: auto;">

                            </td>
                            <td style="width: 44%;margin: auto;">
                                <select required id="upMobileSimAssignTo" style="width: 100%" name="upMobileSimAssignTo"
                                        class="custom-select form-control">
                                    <option disabled value="0" selected>Select Employee</option>
                                    @foreach($employees as $employee)
                                        <option value="{{$employee->id}}">{{$employee->employee_number}}/{{$employee->emp_name}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td style="width: 6%;margin: auto;">

                            </td>
                        </tr>
                    </table>
                    <input type="hidden" id="upMobileSimId">
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" id="upMobileSimBtn" class="btn btn-primary">Save</button>
                </div>
            </form>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

