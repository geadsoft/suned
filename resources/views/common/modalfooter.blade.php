</div>
      <div class="modal-footer">
        @If($seleted_id<0)
            <button type="button" wire.click.prevent="resetUI()" class="btn btn-dark close-btn text-info">Save Record</button>
        @else
            <button type="button" wire.click.prevent="update()" class="btn btn-dark close-modal">Update Record</button>
        @endif
        <button type="button" wire.click.prevent="store()" class="btn btn-dark close-modal" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>