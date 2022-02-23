<script>
    let callbackFunctionImage = ()=>{};
</script>
<div class="modal fade" id="modalImageSelector" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalImageSelectorLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalImageSelectorLabel">{{__('Select image')}}</h5>
            </div>
            <div class="modal-body">
                @include('includes.images')
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" onclick="closeModalSelector()" >{{__('Close')}}</button>
                <button type="button" class="btn btn-primary" onclick="saveModalSelector()">{{__('Select')}}</button>
            </div>
        </div>
    </div>
</div>
<script>
    function closeModalSelector(){
        image_component.image_selected = null;
        image_component.search = "";
        $('#modalImageSelector').modal('hide');
    }
    function saveModalSelector(){
        let image = image_component.image_selected;
        mage_component.image_selected = null;
        image_component.search = "";
        callbackFunctionImage(image);
        $('#modalImageSelector').modal('hide');
    }
</script>
