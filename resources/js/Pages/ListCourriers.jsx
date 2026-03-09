import { useEffect, useState } from "react";

export default function ListCourriers() {

    const [courriers, setCourriers] = useState([]);
    const [search, setSearch] = useState("");

    useEffect(() => {

        fetch("/api/courriers")
        .then(res => res.json())
        .then(data => {
            setCourriers(data);
        });

    }, []);

    const filtered = courriers.filter(c => {

        const numero = c.numero ? c.numero.toLowerCase() : "";
        const objet = c.objet ? c.objet.toLowerCase() : "";
        const s = search.toLowerCase();

        return numero.includes(s) || objet.includes(s);

    });

    return (

        <div className="p-10 bg-gray-100 min-h-screen">

            <div className="max-w-6xl mx-auto bg-white shadow-lg rounded-lg p-8">

                <h1 className="text-3xl font-bold mb-6 text-gray-800">
                    Liste des Courriers
                </h1>

                <input
                    type="text"
                    placeholder="Rechercher un courrier..."
                    value={search}
                    onChange={(e)=>setSearch(e.target.value)}
                    className="border border-gray-300 rounded-lg p-3 w-full mb-6 focus:outline-none focus:ring-2 focus:ring-blue-400"
                />

                <table className="w-full border border-gray-200 rounded-lg overflow-hidden">

                    <thead className="bg-gray-200 text-gray-700">

                        <tr>
                            <th className="p-3 border">Numero</th>
                            <th className="p-3 border">Objet</th>
                            <th className="p-3 border">Type</th>
                            <th className="p-3 border">Service</th>
                            <th className="p-3 border">PDF</th>
                            <th className="p-3 border">Télécharger</th>
                        </tr>

                    </thead>

                    <tbody>

                    {filtered.length === 0 ? (

                        <tr>
                            <td colSpan="6" className="text-center p-6 text-gray-500">
                                Aucun courrier trouvé
                            </td>
                        </tr>

                    ) : (

                        filtered.map(c => {

                            const service = c.affectations?.[0]?.service?.nom_service || "-";

                            return (

                                <tr key={c.id} className="hover:bg-gray-100">

                                    <td className="border p-3">{c.numero}</td>

                                    <td className="border p-3">{c.objet}</td>

                                    <td className="border p-3">
                                        <span className="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm">
                                            {c.type}
                                        </span>
                                    </td>

                                    <td className="border p-3">{service}</td>

                                    <td className="border p-3 text-center">

                                        <a
                                            href={`/storage/${c.fichier}`}
                                            target="_blank"
                                            className="text-blue-600 font-semibold hover:underline"
                                        >
                                            Voir
                                        </a>

                                    </td>

                                    <td className="border p-3 text-center">

                                        <a
                                            href={`/api/courriers/${c.id}/pdf`}
                                            className="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600"
                                        >
                                            Télécharger
                                        </a>

                                    </td>

                                </tr>

                            )

                        })

                    )}

                    </tbody>

                </table>

            </div>

        </div>

    );

}