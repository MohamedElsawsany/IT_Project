<div class="modal fade" id="editPCModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit PC <span id="editPCBrandName" style="color: red"></span> - <span id="editPCModelName" style="color: red"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form autocomplete="off" id="editPCForm">
                <div class="modal-body">
                    <table style="width:100%;" class="table table-borderless nowrap display">
                        <tr>
                            <td style="width:44%;margin: auto;">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                            <span class="input-group-text"
                                  id="inputGroup-sizing-default-up_pc_serial_number">Serial.No</span>
                                    </div>
                                    <input type="text" class="form-control col-xs-3" required id="UpPcSerialNumber"
                                           name="UpPcSerialNumber" aria-label="Sizing example input"
                                           aria-describedby="inputGroup-sizing-default-up_pc_serial_number"
                                           autocomplete="off">
                                </div>
                            </td>
                            <td style="width:6%;margin: auto;">

                            </td>

                            <td style="width:44%;margin: auto;">
                                <select required id="UpPcBrand" style="width: 100%" name="UpPcBrand"
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
                            <td style="width: 44%;margin: auto;">
                                <select required id="UpPcModel" style="width: 100%" name="UpPcModel"
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
                                <select required id="UpPcCpu" style="width: 100%" name="UpPcCpu"
                                        class="custom-select form-control">
                                    <option disabled value="0" selected>Select CPU</option>
                                    @foreach($cpus as $cpu)
                                        <option value="{{$cpu->id}}">{{$cpu->cpu_name}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td style="width: 6%;margin: auto;">
                                <button type="button" class="btn btn-outline-primary" data-toggle="modal"
                                        data-target="#addCPUModal">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </td>

                        </tr>
                        <tr>
                            <td style="width: 44%;margin: auto;">
                                <select required id="UpPcGpu1" style="width: 100%" name="UpPcGpu1"
                                        class="custom-select form-control">
                                    <option disabled value="0" selected>Select Primary GPU</option>
                                    @foreach($gpus as $gpu)
                                        <option value="{{$gpu->id}}">{{$gpu->gpu_name}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td style="width: 6%;margin: auto;">

                            </td>

                            <td style="width: 44%;margin: auto;">
                                <select id="UpPcGpu2" style="width: 100%" name="UpPcGpu2"
                                        class="custom-select form-control">
                                    <option disabled value="0" selected>Select Secondary GPU</option>
                                    @foreach($gpus as $gpu)
                                        <option value="{{$gpu->id}}">{{$gpu->gpu_name}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td style="width: 6%;margin: auto;">
                                <button type="button" class="btn btn-outline-primary" data-toggle="modal"
                                        data-target="#addGPUModal">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:44%;margin: auto;">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                            <span class="input-group-text"
                                  id="inputGroup-sizing-default-UpHDDStoragePC">HDD Storage(GB)</span>
                                    </div>
                                    <input type="number" class="form-control col-xs-3" required id="UpPcHdd"
                                           name="UpPcHdd" aria-label="Sizing example input"
                                           aria-describedby="inputGroup-sizing-default-UpHDDStoragePC"
                                           autocomplete="off">
                                </div>
                            </td>
                            <td style="width:6%;margin: auto;">

                            </td>
                            <td style="width:44%;margin: auto;">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                            <span class="input-group-text"
                                  id="inputGroup-sizing-default-UpSSDStoragePC">SSD Storage(GB)</span>
                                    </div>
                                    <input type="number" class="form-control col-xs-3" required id="UpPcSsd"
                                           name="UpPcSsd" aria-label="Sizing example input"
                                           aria-describedby="inputGroup-sizing-default-UpSSDStoragePC"
                                           autocomplete="off">
                                </div>
                            </td>
                            <td style="width:6%;margin: auto;">

                            </td>
                        </tr>
                        <tr>
                            <td style="width:44%;margin: auto;">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                            <span class="input-group-text"
                                  id="inputGroup-sizing-default-UpRam">Ram</span>
                                    </div>
                                    <input type="text" class="form-control col-xs-3" required id="UpPcRam"
                                           name="UpPcRam" aria-label="Sizing example input"
                                           aria-describedby="inputGroup-sizing-default-UpRam" autocomplete="off">
                                </div>
                            </td>
                            <td style="width:6%;margin: auto;">

                            </td>
                            <td style="width:44%;margin: auto;">
                                <select required id="UpPcOS" style="width: 100%" name="UpPcOS"
                                        class="custom-select form-control">
                                    <option disabled value="0" selected>Select Operating System</option>
                                    @foreach($operating_systems as $operating_system)
                                        <option
                                            value="{{$operating_system->id}}">{{$operating_system->os_name}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td style="width:6%;margin: auto;">
                                <button type="button" class="btn btn-outline-primary" data-toggle="modal"
                                        data-target="#addOSModal">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </td>
                        </tr>

                        <tr>
                            <td style="width:44%;margin: auto;">
                                <select required id="UpPcLocation" style="width: 100%" name="UpPcLocation"
                                        class="custom-select form-control">
                                    <option disabled value="0" selected>Select Location</option>
                                    @foreach($locations as $location)
                                        <option value="{{$location->id}}">{{$location->activity}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td style="width:6%;margin: auto;">

                            </td>
                            <td style="width:44%;margin: auto;">
                                <select required id="UpPcFlag" style="width: 100%" name="UpPcFlag"
                                        class="custom-select form-control">
                                    <option disabled value="0" selected>Select Flag</option>
    @foreach($flags as $flag)
        @if($flag->id !== 2)
            <option value="{{$flag->id}}">{{$flag->flag_name}}</option>
        @endif
    @endforeach
                                </select>
                            </td>
                            <td style="width:6%;margin: auto;">

                            </td>
                        </tr>

                    </table>
                    <input type="hidden" id="hiddenModelValue">
                    <input type="hidden" id="UpPcId">
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" id="upPcBtn" class="btn btn-primary">Save</button>
                </div>
            </form>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

