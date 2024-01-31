<script>
    function openBanModal(userId) {
        const modal = document.getElementById('banModal-'+userId);
        modal.style.display = 'block';
    }

    function closeBanModal(userId) {
        const modal = document.getElementById('banModal-'+userId);
        modal.style.display = 'none';
    }

    function openUnBanModal(userId) {
        const modal = document.getElementById('unBanModal-'+userId);
        modal.style.display = 'block';
    }

    function closeUnBanModal(userId) {
        const modal = document.getElementById('unBanModal-'+userId);
        modal.style.display = 'none';
    }

    function openDeleteModal(userId) {
        const modal = document.getElementById('deleteModal-'+userId);
        modal.style.display = 'block';
    }

    function closeDeleteModal(userId) {
        const modal = document.getElementById('deleteModal-'+userId);
        modal.style.display = 'none';
    }
</script>
