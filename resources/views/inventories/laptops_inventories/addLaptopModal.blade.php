<div class="modal fade" id="addLaptopModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New Laptop</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form autocomplete="off" id="addLaptopForm">
                <div class="modal-body">
                    <table style="width:100%;" class="table table-borderless nowrap display">
                        <tr>
                            <td style="width:44%;margin: auto;">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                                            <span class="input-group-text"
                                                                  id="inputGroup-sizing-default-LaptopSerialNumber">Serial.No</span>
                                    </div>
                                    <input type="text" class="form-control col-xs-3" required id="LaptopSerialNumber"
                                           name="LaptopSerialNumber" aria-label="Sizing example input"
                                           aria-describedby="inputGroup-sizing-default-LaptopSerialNumber"
                                           autocomplete="off">
                                </div>
                            </td>
                            <td style="width:6%;margin: auto;">

                            </td>

                            <td style="width:44%;margin: auto;">
                                <select required id="LaptopBrand" style="width: 100%" name="LaptopBrand"
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
                                <select required id="LaptopModel" style="width: 100%" name="LaptopModel"
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
                                <select required id="LaptopCPU" style="width: 100%" name="LaptopCPU"
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
                                <select required id="LaptopGPU1" style="width: 100%" name="LaptopGPU1"
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
                                <select id="LaptopGPU2" style="width: 100%" name="LaptopGPU2"
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
                                                                  id="inputGroup-sizing-default-HDDStorageLaptop">HDD Storage(GB)</span>
                                    </div>
                                    <input type="number" class="form-control col-xs-3" required id="LaptopHDD"
                                           name="LaptopHDD" aria-label="Sizing example input" value="0"
                                           aria-describedby="inputGroup-sizing-default-HDDStorageLaptop"
                                           autocomplete="off">
                                </div>
                            </td>
                            <td style="width:6%;margin: auto;">

                            </td>
                            <td style="width:44%;margin: auto;">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                                            <span class="input-group-text"
                                                                  id="inputGroup-sizing-default-SSDStorageLaptop">SSD Storage(GB)</span>
                                    </div>
                                    <input type="number" class="form-control col-xs-3" required id="LaptopSSD"
                                           name="LaptopSSD" aria-label="Sizing example input" value="0"
                                           aria-describedby="inputGroup-sizing-default-SSDStorageLaptop"
                                           autocomplete="off">
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
                                                                  id="inputGroup-sizing-default-LaptopRam">Ram</span>
                                    </div>
                                    <input type="text" class="form-control col-xs-3" required id="LaptopRam"
                                           name="LaptopRam" aria-label="Sizing example input" value="0 GB"
                                           aria-describedby="inputGroup-sizing-default-LaptopRam" autocomplete="off">
                                </div>
                            </td>
                            <td style="width:6%;margin: auto;">

                            </td>
                            <td style="width:44%;margin: auto;">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                                            <span class="input-group-text"
                                                                  id="inputGroup-sizing-default-LaptopScreen">Screen(Inch)</span>
                                    </div>
                                    <input type="text" class="form-control col-xs-3" required id="LaptopScreen"
                                           name="LaptopScreen" aria-label="Sizing example input"
                                           aria-describedby="inputGroup-sizing-default-LaptopScreen" autocomplete="off">
                                </div>
                            </td>
                            <td style="width:6%;margin: auto;">

                            </td>
                        </tr>

                        <tr>
                            <td style="width:44%;margin: auto;">
                                <select required id="LaptopOS" style="width: 100%" name="LaptopOS"
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
                                <select required id="LaptopLocation" style="width: 100%" name="LaptopLocation"
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
                                <select required id="LaptopFlag" style="width: 100%" name="LaptopFlag"
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
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" id="addLaptopBtn" class="btn btn-primary">Save</button>
                </div>
            </form>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
