class Card {
    constructor(title, description, actionUrl) {
        this.title = title;
        this.description = description;
        this.actionUrl = actionUrl;
    }

    render() {
        const cardDiv = document.createElement('div');
        cardDiv.className = 'card';

        const titleElement = document.createElement('h3');
        titleElement.textContent = this.title;
        cardDiv.appendChild(titleElement);

        const descriptionElement = document.createElement('p');
        descriptionElement.textContent = this.description;
        cardDiv.appendChild(descriptionElement);

        const form = document.createElement('form');
        form.action = this.actionUrl;

        const button = document.createElement('button');
        button.type = 'submit';
        button.className = 'btn';
        button.textContent = 'Click!';
        form.appendChild(button);

        cardDiv.appendChild(form);

        return cardDiv;
    }
}

const cards = [
    new Card('Order Commission', 'Get your own commission.', './common/form/order.php'),
];

const cardContainer = document.getElementById('cardContainer');

cards.forEach(card => {
    cardContainer.appendChild(card.render());
});