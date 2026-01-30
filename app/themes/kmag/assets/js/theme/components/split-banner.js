/* eslint-env jquery */
const $ = jQuery;
const initSplitBannerModule = () => {
    $('.yt__play-btn').on('click', function () {
        $('iframe[data-backup_src]').each(function () {
            if ($(this).attr('src') === '') {
                $(this).attr('src', $(this).attr('data-backup_src'));
            }
        });
    });
    $(document).on('modal_is_closed', function () {
        $('iframe[data-backup_src]').each(function () {
            $(this).attr('src', '');
        });
    });
}
export default initSplitBannerModule;
