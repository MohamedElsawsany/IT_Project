<div class="modal fade" id="addSwitchModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New Switch</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form autocomplete="off" id="addSwitchForm">
                <div class="modal-body">
                    <table style="width:100%;" class="table table-borderless nowrap display">
                        <tr>
                            <td style="width:44%;margin: auto;">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-default-switchSerialNumber">Serial.No</span>
                                    </div>
                                    <input type="text" class="form-control col-xs-3" required id="switchSerialNumber"
                                           name="switchSerialNumber" aria-label="Sizing example input"
                                           aria-describedby="inputGroup-sizing-default-switchSerialNumber"
                                           autocomplete="off">
                                </div>
                            </td>
                            <td style="width:6%;margin: auto;">

                            </td>

                            <td style="width:44%;margin: auto;">
                                <select required id="switchBrand" style="width: 100%" name="switchBrand"
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
                                <select required id="switchModel" style="width: 100%" name="switchModel"
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
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-default-switchPorts">Ports.No</span>
                                    </div>
                                    <input type="text" class="form-control col-xs-3" required id="switchPorts"
                                           name="switchPorts" aria-label="Sizing example input"
                                           aria-describedby="inputGroup-sizing-default-switchPorts"
                                           autocomplete="off">
                                </div>
                            </td>
                            <td style="width: 6%;margin: auto;">

                            </td>
                        </tr>
                        <tr>
                            <td style="width: 44%;margin: auto;">
                                <select required id="switchLocation" style="width: 100%" name="switchLocation"
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
                                <select required id="switchFlag" style="width: 100%" name="switchFlag"
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
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" id="addSwitchBtn" class="btn btn-primary">Save</button>
                </div>
            </form>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
