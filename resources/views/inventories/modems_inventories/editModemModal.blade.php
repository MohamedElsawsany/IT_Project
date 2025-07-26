<div class="modal fade" id="editModemModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Modem <span id="editModemBrandName" style="color: red"></span> - <span id="editModemModelName" style="color: red"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form autocomplete="off" id="editModemForm">
                <div class="modal-body">
                    <table style="width:100%;" class="table table-borderless nowrap display">
                        <tr>
                            <td style="width:44%;margin: auto;">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                            <span class="input-group-text"
                                  id="inputGroup-sizing-default-upModemSerialNumber">Serial.No</span>
                                    </div>
                                    <input type="text" class="form-control col-xs-3" required id="upModemSerialNumber"
                                           name="upModemSerialNumber" aria-label="Sizing example input"
                                           aria-describedby="inputGroup-sizing-default-upModemSerialNumber"
                                           autocomplete="off">
                                </div>
                            </td>
                            <td style="width:6%;margin: auto;">

                            </td>

                            <td style="width:44%;margin: auto;">
                                <select required id="upModemBrand" style="width: 100%" name="upModemBrand"
                                        class="custom-select form-control">
                                    <option disabled value="0" selected>Select Brand</option>
                                    @foreach($brands as $brand)
                                        <option value="{{$brand->id}}">{{$brand->brand_name}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td style="width: 6%;margin: auto;">
                                <button type="button" class="btn btn-outline-primary" data-toggle="modal"
                                        data-target="#addBrandModal">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:44%;margin: auto;">
                                <select required id="upModemModel" style="width: 100%" name="upModemModel"
                                        class="custom-select form-control">
                                    <option disabled value="0" selected>Select Model</option>
                                </select>
                            </td>
                            <td style="width: 6%;margin: auto;">
                                <button type="button" class="btn btn-outline-primary" data-toggle="modal"
                                        data-target="#addModelModal">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </td>
                            <td style="width: 44%;margin: auto;">
                                <select required id="upModemType" style="width: 100%" name="upModemType"
                                        class="custom-select form-control">
                                    <option disabled value="0" selected>Select Modem Type</option>
                                    @foreach($modemsTypes as $modemType)
                                        <option value="{{$modemType->id}}">{{$modemType->type_name}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td style="width: 6%;margin: auto;">

                            </td>
                        </tr>
                        <tr>
                            <td style="width: 44%;margin: auto;">
                                <select required id="upModemLocation" style="width: 100%" name="upModemLocation"
                                        class="custom-select form-control">
                                    <option disabled value="0" selected>Select Location</option>
                                    @foreach($locations as $location)
                                        <option value="{{$location->id}}">{{$location->activity}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td style="width: 6%;margin: auto;">

                            </td>

                            <td style="width: 44%;margin: auto;">
                                <select required id="upModemFlag" style="width: 100%" name="upModemFlag"
                                        class="custom-select form-control">
                                    <option disabled value="0" selected>Select Flag</option>
    @foreach($flags as $flag)
        @if($flag->id !== 2)
            <option value="{{$flag->id}}">{{$flag->flag_name}}</option>
        @endif
    @endforeach
                                </select>
                            </td>
                            <td style="width: 6%;margin: auto;">

                            </td>
                        </tr>

                    </table>
                    <input type="hidden" id="upModemId">
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" id="upModemBtn" class="btn btn-primary">Save</button>
                </div>
            </form>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

