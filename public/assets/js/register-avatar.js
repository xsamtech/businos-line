document.addEventListener('DOMContentLoaded', () => {
    const picker = document.getElementById('avatar-picker');
    const source = document.getElementById('avatar-source');
    const dialog = document.getElementById('avatar-dialog');
    const cropImage = document.getElementById('avatar-crop-image');
    const apply = document.getElementById('avatar-apply');
    const cancel = document.getElementById('avatar-cancel');
    const preview = document.getElementById('avatar-preview');
    const placeholder = document.getElementById('avatar-placeholder');
    const base64 = document.getElementById('avatar-base64');
    let cropper = null;

    picker?.addEventListener('click', () => source.click());
    source?.addEventListener('change', () => {
        const file = source.files?.[0];
        if (!file || !['image/jpeg', 'image/png', 'image/webp'].includes(file.type)) return;
        const reader = new FileReader();
        reader.addEventListener('load', () => {
            cropImage.src = reader.result;
            dialog.showModal();
            cropper?.destroy();
            cropper = new Cropper(cropImage, { aspectRatio: 1, viewMode: 1, autoCropArea: 1, background: false, responsive: true });
        });
        reader.readAsDataURL(file);
    });

    apply?.addEventListener('click', () => {
        if (!cropper) return;
        const result = cropper.getCroppedCanvas({ width: 512, height: 512, imageSmoothingEnabled: true, imageSmoothingQuality: 'high' }).toDataURL('image/jpeg', 0.88);
        base64.value = result;
        preview.src = result;
        preview.classList.remove('hidden');
        placeholder.classList.add('hidden');
        cropper.destroy();
        cropper = null;
        dialog.close();
    });

    cancel?.addEventListener('click', () => {
        cropper?.destroy();
        cropper = null;
        source.value = '';
        dialog.close();
    });
});
