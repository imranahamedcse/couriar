<div class="modal fade" id="parcelstatus{{ \App\Enums\ParcelStatus::DELIVERY_MAN_ASSIGN }}"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content" id="data-modal">

        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{ __('parcelStatus.'.\App\Enums\ParcelStatus::DELIVERY_MAN_ASSIGN) }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('parcel.delivery-man-assign') }}" method="post">
            @csrf
            <input type="hidden" value="" name="parcel_id" id="modal_parcel_id" class="modal_parcel_id"/>
            <div class="modal-body">

                <div class="form-group  ">
                    <label for="delivery_man_search">{{ __('deliveryman.title')}}</label> <span class="text-danger">*</span>
                    <div class="form-control-wrap deliveryman-search">
                        <select id="delivery_man_search" class="form-control delivery_man_search" name="delivery_man_id" data-url="{{ route('parcel.deliveryman.search') }}" >
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
                <div class="form-group  ">
                    <label for="note">{{ __('parcel.note')}}</label>
                    <div class="form-control-wrap deliveryman-search">
                       <textarea class="form-control" name="note" rows="5"></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="custom-control custom-checkbox">
                        <input id="send_sms" name="send_sms" class="custom-control-input" type="checkbox"><span class="custom-control-label">Send SMS</span>
                    </label>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>

    </div>
</div>
</div>
