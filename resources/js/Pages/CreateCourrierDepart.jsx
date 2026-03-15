import { useEffect, useState } from "react";
import { router } from "@inertiajs/react";

export default function CreateCourrierDepart() {
  const [numero, setNumero] = useState("");
  const [annee, setAnnee] = useState(new Date().getFullYear());
  const [objet, setObjet] = useState("");
  const [type, setType] = useState("");
  const [dateDepart, setDateDepart] = useState("");
  const [destinataire, setDestinataire] = useState("");
  const [modeEnvoi, setModeEnvoi] = useState("");
  const [description, setDescription] = useState("");
  const [nombrePieces, setNombrePieces] = useState("");
  const [observations, setObservations] = useState("");
  const [natureId, setNatureId] = useState("");
  const [natures, setNatures] = useState([]);
  const [courrierArriveId, setCourrierArriveId] = useState("");
  const [courriers, setCourriers] = useState([]);
  const [fichier, setFichier] = useState(null);
  const [existingFile, setExistingFile] = useState("");
  const [loading, setLoading] = useState(false);

  const today = new Date().toISOString().split("T")[0];

  // استخراج id من query string: /courrier-departs/create?id=3
  const searchParams = new URLSearchParams(window.location.search);
  const id = searchParams.get("id");
  const isEdit = !!id;

  useEffect(() => {
    fetch("/api/natures")
      .then((res) => res.json())
      .then((data) => setNatures(data))
      .catch((err) => console.error("Erreur natures:", err));

    fetch("/api/courriers")
      .then((res) => res.json())
      .then((data) => setCourriers(data))
      .catch((err) => console.error("Erreur courriers:", err));
  }, []);

  useEffect(() => {
    if (!isEdit) {
      fetch("/api/courrier-departs/next-number?annee=" + annee)
        .then((res) => res.json())
        .then((data) => {
          setNumero(data.numero);
        })
        .catch((err) => console.error("Erreur next number:", err));
    }
  }, [annee, isEdit]);

  useEffect(() => {
    if (isEdit && id) {
      fetch(`/api/courrier-departs/${id}`)
        .then(async (res) => {
          if (!res.ok) {
            throw new Error("Erreur lors du chargement du courrier");
          }
          return res.json();
        })
        .then((data) => {
          setNumero(data.numero || "");
          setAnnee(data.annee || new Date().getFullYear());
          setObjet(data.objet || "");
          setType(data.type || "");
          setDateDepart(data.date_depart || "");
          setDestinataire(data.destinataire_externe || "");
          setModeEnvoi(data.mode_envoi || "");
          setDescription(data.description || "");
          setNombrePieces(data.nombre_pieces || "");
          setObservations(data.observations || "");
          setNatureId(data.nature_id || "");
          setCourrierArriveId(data.courrier_arrive_id || "");
          setExistingFile(data.fichier || "");
        })
        .catch((err) => {
          console.error(err);
          alert("Erreur lors du chargement du courrier");
        });
    }
  }, [id, isEdit]);

  const submitForm = (e) => {
    e.preventDefault();

    if (!objet || !dateDepart || !destinataire || !modeEnvoi || !natureId) {
      alert("Veuillez remplir les champs obligatoires");
      return;
    }

    setLoading(true);

    const formData = new FormData();
    formData.append("numero", numero);
    formData.append("annee", annee);
    formData.append("type", type);
    formData.append("objet", objet);
    formData.append("date_depart", dateDepart);
    formData.append("destinataire_externe", destinataire);
    formData.append("mode_envoi", modeEnvoi);
    formData.append("description", description);
    formData.append("nombre_pieces", nombrePieces);
    formData.append("observations", observations);
    formData.append("nature_id", natureId);
    formData.append("courrier_arrive_id", courrierArriveId);

    if (fichier) {
      formData.append("fichier", fichier);
    }

    const url = isEdit
      ? `/api/courrier-departs/${id}`
      : "/api/courrier-departs";

    if (isEdit) {
      formData.append("_method", "PUT");
    }

    fetch(url, {
      method: "POST",
      body: formData,
    })
      .then(async (res) => {
        const data = await res.json();
        if (!res.ok) {
          throw new Error(data.message || "Erreur");
        }
        return data;
      })
      .then(() => {
        alert(
          isEdit
            ? "Courrier départ modifié avec succès"
            : "Courrier départ ajouté avec succès"
        );
        router.visit("/courrier-departs");
      })
      .catch((err) => {
        console.error(err);
        alert(
          isEdit
            ? "Erreur lors de la modification"
            : "Erreur lors de l'ajout"
        );
        setLoading(false);
      });
  };

  return (
    <div className="min-h-screen bg-gray-100 flex">
      <div className="w-64 bg-[#0f172a] text-white min-h-screen shadow-xl">
        <div className="p-6 border-b border-slate-700 flex flex-col items-center">
          <img
            src="/images/wilaya (1).png"
            alt="Logo Wilaya"
            className="w-20 h-20 object-contain mb-3"
          />
          <h2 className="text-lg font-bold text-center leading-6">
            Gestion Courrier
          </h2>
        </div>

        <div className="p-4 space-y-3">
          <button
            onClick={() => router.visit("/")}
            className="w-full text-left bg-slate-800 hover:bg-slate-700 px-4 py-3 rounded-lg transition"
          >
            Accueil
          </button>

          <button
            onClick={() => router.visit("/courrier-departs")}
            className="w-full text-left bg-slate-800 hover:bg-slate-700 px-4 py-3 rounded-lg transition"
          >
            Liste courrier départ
          </button>
        </div>
      </div>

      <div className="flex-1">
        <div className="bg-white shadow-md px-8 py-4 flex justify-between items-center">
          <h1 className="text-2xl font-bold text-gray-700">
            {isEdit ? "Modifier Courrier Départ" : "Nouveau Courrier Départ"}
          </h1>

          <button
            type="button"
            onClick={() => router.visit("/")}
            className="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg"
          >
            Accueil
          </button>
        </div>

        <div className="p-8">
          <div className="max-w-4xl mx-auto bg-white shadow-xl rounded-xl p-8">
            <form onSubmit={submitForm} className="space-y-5">
              <div className="grid grid-cols-2 gap-4">
                <div>
                  <label>Année</label>
                  <input
                    type="number"
                    value={annee}
                    onChange={(e) => setAnnee(e.target.value)}
                    className="w-full border p-2 rounded"
                    disabled={isEdit}
                  />
                </div>

                <div>
                  <label>Numéro</label>
                  <input
                    type="text"
                    value={numero}
                    onChange={(e) => setNumero(e.target.value)}
                    className="w-full border p-2 rounded"
                    disabled={isEdit}
                  />
                </div>
              </div>

              <div>
                <label>Date de départ *</label>
                <input
                  type="date"
                  value={dateDepart}
                  max={today}
                  onChange={(e) => setDateDepart(e.target.value)}
                  className="w-full border p-2 rounded"
                />
              </div>

              <div>
                <label>Objet *</label>
                <input
                  type="text"
                  value={objet}
                  onChange={(e) => setObjet(e.target.value)}
                  className="w-full border p-2 rounded"
                />
              </div>

              <div>
                <label>Type de courrier</label>
                <select
                  value={type}
                  onChange={(e) => setType(e.target.value)}
                  className="w-full border p-2 rounded"
                >
                  <option value="">Choisir type</option>
                  <option value="Facture">Facture</option>
                  <option value="Note">Note</option>
                  <option value="Réclamation">Réclamation</option>
                  <option value="Officiel">Officiel</option>
                </select>
              </div>

              <div>
                <label>Destinataire externe *</label>
                <input
                  type="text"
                  value={destinataire}
                  onChange={(e) => setDestinataire(e.target.value)}
                  className="w-full border p-2 rounded"
                />
              </div>

              <div>
                <label>Mode d'envoi *</label>
                <select
                  value={modeEnvoi}
                  onChange={(e) => setModeEnvoi(e.target.value)}
                  className="w-full border p-2 rounded"
                >
                  <option value="">Choisir</option>
                  <option value="Poste">Poste</option>
                  <option value="Email">Email</option>
                  <option value="Remise en main propre">Remise en main propre</option>
                </select>
              </div>

              <div>
                <label>Nature *</label>
                <select
                  value={natureId}
                  onChange={(e) => setNatureId(e.target.value)}
                  className="w-full border p-2 rounded"
                >
                  <option value="">Choisir nature</option>
                  {natures.map((n) => (
                    <option key={n.id} value={n.id}>
                      {n.nom}
                    </option>
                  ))}
                </select>
              </div>

              <div>
                <label>Réponse à (courrier arrivé)</label>
                <select
                  value={courrierArriveId}
                  onChange={(e) => setCourrierArriveId(e.target.value)}
                  className="w-full border p-2 rounded"
                >
                  <option value="">Pas de réponse</option>
                  {courriers.map((c) => (
                    <option key={c.id} value={c.id}>
                      {c.numero} - {c.objet}
                    </option>
                  ))}
                </select>
              </div>

              <div>
                <label>Nombre de pièces</label>
                <input
                  type="number"
                  value={nombrePieces}
                  onChange={(e) => setNombrePieces(e.target.value)}
                  className="w-full border p-2 rounded"
                />
              </div>

              <div>
                <label>Description</label>
                <textarea
                  value={description}
                  onChange={(e) => setDescription(e.target.value)}
                  className="w-full border p-2 rounded"
                />
              </div>

              <div>
                <label>Observations</label>
                <textarea
                  value={observations}
                  onChange={(e) => setObservations(e.target.value)}
                  className="w-full border p-2 rounded"
                />
              </div>

              <div>
                <label>Scan courrier (PDF)</label>
                <input
                  type="file"
                  accept="application/pdf"
                  onChange={(e) => setFichier(e.target.files[0])}
                  className="w-full border p-2 rounded"
                />
                {existingFile && !fichier && (
                  <p className="text-sm text-green-600 mt-2">
                    Fichier actuel déjà enregistré
                  </p>
                )}
              </div>

              <button
                type="submit"
                disabled={loading}
                className="bg-green-600 text-white px-6 py-3 rounded w-full hover:bg-green-700"
              >
                {loading
                  ? isEdit
                    ? "Modification..."
                    : "Enregistrement..."
                  : isEdit
                  ? "Modifier"
                  : "Enregistrer"}
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  );
}