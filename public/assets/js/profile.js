const orders = document.getElementsByClassName('order');

for (let i = 0; i < orders.length; i++) {
    orders[i].addEventListener('click', () => {

        if (orders[i].querySelector('.order-detail').classList.contains('active')) {
            orders[i].querySelector('.order-detail').classList.remove('active');
            orders[i].querySelector('.open-icon').classList.add('fa-chevron-down');
            orders[i].querySelector('.open-icon').classList.remove('fa-chevron-up');
        } else {
            for (let i = 0; i < orders.length; i++) {
                orders[i].querySelector('.order-detail').classList.remove('active');
            }
            orders[i].querySelector('.order-detail').classList.add('active');
            orders[i].querySelector('.open-icon').classList.remove('fa-chevron-down');
            orders[i].querySelector('.open-icon').classList.add('fa-chevron-up');
        }
    })
}

