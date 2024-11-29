/* Color theme class */

class ColorTheme
{
    #color = "";
    #r = 0;
    #g = 0;
    #b = 0;
    #h = 0;
    #s = 0;
    #l = 0;

    constructor(color)
    {
        this.#color = color;
        this.#r = Number('0x' + color.substring(1, 3));
        this.#g = Number('0x' + color.substring(3, 5));
        this.#b = Number('0x' + color.substring(5, 7));
        this.#rgbToHsl();
    }

    // Set theme colors

    setDivBgColor(id)
    {
        let elm = document.getElementById(id);
        if (elm)
        {
            elm.style.backgroundColor = this.#color;
            elm.style.color = '#fff';
        }
    }

    setTableColors(id)
    {
        let elm = document.getElementById(id);
        if (elm)
        {
            let l = 5 * Math.floor(this.#l / 5) + 10;
            let color = this.#getHtmlColor(this.#h, this.#s, l);
            elm.querySelectorAll('th').forEach((e) =>
            {
                e.style.backgroundColor = color;
                e.style.color = '#fff';
            });
            let stripeColor = this.#getHtmlColor(this.#h, this.#s, 95);
            elm = elm.getElementsByTagName('tbody')[0];
            elm.querySelectorAll('tr').forEach((e) =>
            {
                e.addEventListener('mouseenter', (evt) =>
                {
                    let hoverColor = this.#getHtmlColor(this.#h, this.#s, 70);
                    evt.target.style.backgroundColor = hoverColor;
                });
                if (e.rowIndex % 2 == 0) {
                    e.style.backgroundColor = stripeColor;
                    e.addEventListener('mouseleave', (evt) =>
                    {
                        evt.target.style.backgroundColor = this.#getHtmlColor(this.#h, this.#s, 95);
                    });
                }
                else
                {
                    e.addEventListener('mouseleave', (evt) =>
                    {
                        evt.target.style.backgroundColor = '#fff';
                    });
                }
            });
        }
    }

    setButtonColors(id)
    {
        let elm = document.getElementById(id);
        if (elm)
        {
            elm.style.backgroundColor = this.#color;
            elm.style.color = '#fff';
            elm.addEventListener('mouseenter', (evt) =>
            {
                let l = 5 * Math.floor(this.#l / 5) + 20;
                let hoverColor = this.#getHtmlColor(this.#h, this.#s, l);
                evt.target.style.backgroundColor = hoverColor;
            });
            elm.addEventListener('mouseleave', (evt) =>
            {
                evt.target.style.backgroundColor = this.#color;
            });
        }
    }

    setLoaderColor(id)
    {
        let elm = document.getElementById(id);
        if (elm)
        {
            elm.style.borderTopColor = this.#color;
        }
    }

    setLinkColor(id)
    {
        let elm = document.getElementById(id);
        if (elm)
        {
            elm.style.color = this.#color;
            elm.addEventListener('mouseenter', (evt) =>
            {
                let hoverColor = this.#getHtmlColor(this.#h, this.#s, 70);
                evt.target.style.color = hoverColor;
            });
            elm.addEventListener('mouseleave', (evt) =>
            {
                evt.target.style.color = this.#color;
            });
        }
    }

    // Helpers

    #getHtmlColor(h, s, l)
    {
        let r = 0;
        let g = 0;
        let b = 0;

        if (h == null) h = this.#h;
        if (s == null) s = this.#s;
        if (l == null) l = this.#l;

        h = h / 360;
        s = s / 100;
        l = l / 100;
        if (s == 0)
        {
            r = 255 * l;
            g = r;
            b = r;
        }
        else
        {
            let t1 = 0;
            if (l < 0.5)
            {
                t1 = l * (1 + s);
            }
            else
            {
                t1 = l + s - l * s;
            }
            let t2 = 2 * l - t1;
            let tr = this.#normalize(h + 1 / 3);
            let tg = h;
            let tb = this.#normalize(h - 1 / 3);
            r = Math.round(255 * this.#convertChannel(tr, t1, t2));
            g = Math.round(255 * this.#convertChannel(tg, t1, t2));
            b = Math.round(255 * this.#convertChannel(tb, t1, t2));
        }
        return "#" + this.#toHex(r) + this.#toHex(g) + this.#toHex(b);
    }

    #normalize(value)
    {
        if (value > 1)
        {
            value--;
        }
        if (value < 0)
        {
            value++;
        }
        return value;
    }

    #convertChannel(value, t1, t2)
    {
        if (6 * value < 1)
        {
            return t2 + (t1 - t2) * 6 * value;
        }
        if (2 * value < 1)
        {
            return t1;
        }
        if (3 * value < 2)
        {
            return t2 + (t1 - t2) * ((2 / 3) - value) * 6;
        }
        return t2;
    }

    #toHex(value)
    {
        return ('0' + value.toString(16)).slice(-2);
    }

    #rgbToHsl()
    {
        let r = this.#r / 255;
        let g = this.#g / 255;
        let b = this.#b / 255;
        let min = Math.min(r, g, b);
        let max = Math.max(r, g, b);
        let diff = max - min;
        let sum = max + min;
        this.#l = sum / 2;
        this.#s = 0;
        if (min != max)
        {
            if (this.#l > 0.5)
            {
                this.#s = diff / (2 - sum);
            }
            else
            {
                this.#s = diff / sum;
            }
        }
        if (r == max)
        {
            this.#h = (g - b) / diff;
        }
        if (g == max)
        {
            this.#h = 2 + (b - r) / diff;
        }
        if (b == max)
        {
            this.#h = 4 + (r - g) / diff;
        }
        this.#h = Math.round(60 * this.#h);
        this.#s = Math.round(100 * this.#s);
        this.#l = Math.round(100 * this.#l);
        if (this.#h < 0)
        {
            this.#h += 360;
        }
    }
}