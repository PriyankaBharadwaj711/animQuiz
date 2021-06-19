const iconButtonRipple = mdc.ripple.MDCRipple.attachTo(document.querySelector('.mdc-icon-button'));
iconButtonRipple.unbounded = true;
const iconToggle = mdc.iconButton.MDCIconButtonToggle.attachTo(document.querySelector('.mdc-icon-button'));

/** Custom javascript code. */
const recordingBtn = document.querySelector('.recording-btn');

recordingBtn.addEventListener('click', function(){
    const _btn = this;

    _btn.classList.toggle('recording-pulse'); 
    _btn.classList.toggle('mdc-ripple-upgraded--background-focused');
    _btn.classList.toggle('recording-off');  
})