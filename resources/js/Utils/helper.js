import moment from "moment"

export default {
    formatRupiah: (angka) => {
        if (angka === null) { return 0 };
        let rupiah = ''
        const angkarev = angka
            .toString()
            .split('')
            .reverse()
            .join('')
        for (let i = 0; i < angkarev.length; i++) {
            if (i % 3 === 0) {
            rupiah += angkarev.substr(i, 3) + '.'
            }
        }
        return rupiah
            .split('', rupiah.length - 1)
            .reverse()
            .join('')
    },
    formatDateTime: (datetime) => {
        const day = moment(datetime).format('dddd')
        let hari
        switch (day) {
            case 'Sunday':
                hari = 'Minggu'
                break
            case 'Monday':
                hari = 'Senin'
                break
            case 'Tuesday':
                hari = 'Selasa'
                break
            case 'Wednesday':
                hari = 'Rabu'
                break
            case 'Thursday':
                hari = 'Kamis'
                break
            case 'Friday':
                hari = 'Jumat'
                break
            case 'Saturday':
                hari = 'Sabtu'
                break
            default:
                hari = '-'
                break
        }

        return hari + ', ' + moment(datetime).format('D-MM-YYYY HH:mm')
    }
}
