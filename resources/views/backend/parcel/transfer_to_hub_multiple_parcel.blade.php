<div class="modal fade" id="transfer_to_hub_multiple_parcel"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content" id="data-modal">

        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{ __('parcelStatus.'.\App\Enums\ParcelStatus::TRANSFER_TO_HUB) }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('parcel.transfer-to-hub-multiple-parcel') }}" method="post">
            @csrf
            <div class="modal-body">

                <div class="row">
                    <div class="col-12 col-md-6">

                        <div class="form-group  ">
                            <label for="transfer_hub">{{ __('hub.to_hub')}}</label> <span class="text-danger">*</span>
                            <div class="form-control-wrap  h">
                                <select id="transfer_hub" class="form-control d" name="hub_id"  data-url="{{ route('parcel.transferHub') }}" >
                                    <option selected disabled>Select Hub</option>
                                    @if (hubIncharge() == 0)
                                        @foreach ($hubs as $hub)
                                            <option value="{{ $hub->id }}">{{ $hub->name }}</option>
                                        @endforeach
                                    @else
                                        @foreach ($hubs as $hub)
                                            @if (hubIncharge() != $hub->id)
                                                <option value="{{ $hub->id }}">{{ $hub->name }}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                                @error('hub_id')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        {{-- @if (Auth::user()->id > 1) --}}
                        {{-- <div class="form-group">
                            <label>{{ __('hub.to_hub')}}</label>
                            <div class="form-control-wrap  h">
                                <select  disabled="true" class="form-control d" data-url="{{ route('parcel.transferHub') }}" >
                                    @foreach ($hubs as $hub)
                                        <option value="{{ $hub->id }}" >{{ $hub->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> --}}
                    {{-- @endif --}}

                        <div class="form-group  ">
                            <label for="delivery_man_search">{{ __('deliveryman.title')}}</label>
                            <div class="form-control-wrap deliveryman-search">
                                <select id="delivery_man_search_hub_multiple_parcel" class="form-control delivery_man_search_hub_multiple_parcel" name="delivery_man_id" data-url="{{ route('parcel.deliveryman.search') }}" >
                                    <option selected disabled>Select delivery man</option>
                                    @foreach ($deliverymans as $deliveryman)
                                        <option value="{{ $deliveryman->id }}">{{ $deliveryman->user->name }}</option>
                                    @endforeach
                                </select>
                                @error('delivery_man_id')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group ">
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                            <label for="track_id">{{ __('levels.track_id')}}</label> <span class="text-danger">*</span>
                            <input id="transfer_to_hub_track_id" type="text" name="track_id" placeholder="Enter Tracking Id" class="form-control">
                            <div class="search_message"></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">

                        <div class="form-group  ">
                            <label for="note">{{ __('parcel.note')}}</label>
                            <div class="form-control-wrap deliveryman-search">
                                {{-- <input type="text" class="form-control" placeholder="Enter note" name="note"> --}}
                                <textarea class="form-control" name="note" rows="12"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="border"></div>
                <div class="row px-3">
                    <div class="table-responsive">
                        <table class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>{{__('###') }}</th>
                                    <th>{{__('merchant.track_id')}}</th>
                                    <th>{{__('levels.hub')}}</th>
                                    <th>{{__('merchant.business_name')}}</th>
                                    <th>{{__('levels.mobile')}}</th>
                                    <th>{{__('parcel.delivert_time')}}</th>
                                    <th>{{__('levels.cash_collection')}}</th>
                                    <th>{{ __('levels.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody id="t_body">
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" id="transfer_to_hub_multiple_parcel_button" class="btn btn-primary">Submit</button>
            </div>
        </form>

    </div>
</div>
</div>
