<div class="modal fade" id="editLaptopModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Laptop <span id="editLaptopBrandName" style="color: red"></span> - <span id="editLaptopModelName" style="color: red"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form autocomplete="off" id="editLaptopForm">
                <div class="modal-body">
                    <table style="width:100%;" class="table table-borderless nowrap display">
                        <tr>
                            <td style="width:44%;margin: auto;">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                            <span class="input-group-text"
                                  id="inputGroup-sizing-default-upLaptopSerialNumber">Serial.No</span>
                                    </div>
                                    <input type="text" class="form-control col-xs-3" required id="upLaptopSerialNumber"
                                           name="upLaptopSerialNumber" aria-label="Sizing example input"
                                           aria-describedby="inputGroup-sizing-default-upLaptopSerialNumber"
                                           autocomplete="off">
                                </div>
                            </td>
                            <td style="width:6%;margin: auto;">

                            </td>

                            <td style="width:44%;margin: auto;">
                                <select required id="upLaptopBrand" style="width: 100%" name="upLaptopBrand"
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
                                <select required id="upLaptopModel" style="width: 100%" name="upLaptopModel"
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
                                <select required id="upLaptopCPU" style="width: 100%" name="upLaptopCPU"
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
                                <select required id="upLaptopGPU1" style="width: 100%" name="upLaptopGPU1"
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
                                <select id="upLaptopGPU2" style="width: 100%" name="upLaptopGPU2"
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
                                  id="inputGroup-sizing-default-upLaptopHDD">HDD Storage(GB)</span>
                                    </div>
                                    <input type="number" class="form-control col-xs-3" required id="upLaptopHDD"
                                           name="upLaptopHDD" aria-label="Sizing example input"
                                           aria-describedby="inputGroup-sizing-default-upLaptopHDD" autocomplete="off">
                                </div>
                            </td>
                            <td style="width:6%;margin: auto;">

                            </td>
                            <td style="width:44%;margin: auto;">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                            <span class="input-group-text"
                                  id="inputGroup-sizing-default-upLaptopSSD">SSD Storage(GB)</span>
                                    </div>
                                    <input type="number" class="form-control col-xs-3" required id="upLaptopSSD"
                                           name="upLaptopSSD" aria-label="Sizing example input"
                                           aria-describedby="inputGroup-sizing-default-upLaptopSSD" autocomplete="off">
                                </div>
                            </td>
                            <td style="width:6%;margin: auto;">

                            </td>
                        </tr>
                        <tr>
                            <td style="width:44%;margin: auto;">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                            <span class="input-group-text"
                                  id="inputGroup-sizing-default-uplaptopRam">Ram</span>
                                    </div>
                                    <input type="text" class="form-control col-xs-3" required id="upLaptopRam"
                                           name="upLaptopRam" aria-label="Sizing example input"
                                           aria-describedby="inputGroup-sizing-default-uplaptopRam" autocomplete="off">
                                </div>
                            </td>
                            <td style="width:6%;margin: auto;">

                            </td>
                            <td style="width:44%;margin: auto;">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                            <span class="input-group-text"
                                  id="inputGroup-sizing-default-upLaptopScreen">Screen(Inch)</span>
                                    </div>
                                    <input type="number" class="form-control col-xs-3" required id="upLaptopScreen"
                                           name="upLaptopScreen" aria-label="Sizing example input"
                                           aria-describedby="inputGroup-sizing-default-upLaptopHDD" autocomplete="off">
                                </div>
                            </td>
                            <td style="width:6%;margin: auto;">

                            </td>
                        </tr>

                        <tr>
                            <td style="width:44%;margin: auto;">
                                <select required id="upLaptopOS" style="width: 100%" name="upLaptopOS"
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
                            <td style="width:44%;margin: auto;">
                                <select required id="upLaptopLocation" style="width: 100%" name="upLaptopLocation"
                                        class="custom-select form-control">
                                    <option disabled value="0" selected>Select Location</option>
                                    @foreach($locations as $location)
                                        <option value="{{$location->id}}">{{$location->activity}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td style="width:6%;margin: auto;">

                            </td>
                        </tr>
                        <tr>
                            <td style="width:44%;margin: auto;">
                                <select required id="upLaptopFlag" style="width: 100%" name="upLaptopFlag"
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
                            <td style="width:44%;margin: auto;">

                            </td>
                            <td style="width:6%;margin: auto;">

                            </td>
                        </tr>

                    </table>
                    <input type="hidden" id="upLaptopId">

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" id="upLaptopBtn" class="btn btn-primary">Save</button>
                </div>
            </form>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
