export const formatCurrency = (value) => {
    return new Intl.NumberFormat('ru-RU', { style: 'currency', currency: 'RUB' }).format(value);
};

export const formatDate = (dateString) => {
    return new Date(dateString).toLocaleString('ru-RU');
};
