import { useEffect, useState } from "react";

export default function Users() {

  const [users, setUsers] = useState([]);
  const [natures, setNatures] = useState([]);
  const [services, setServices] = useState([]);

  useEffect(() => {

    fetch("/api/users")
      .then(res => res.json())
      .then(data => setUsers(data));

    fetch("/api/natures")
      .then(res => res.json())
      .then(data => setNatures(data));

    fetch("/api/services")
      .then(res => res.json())
      .then(data => setServices(data));

  }, []);

  const updateUser = (u) => {

    fetch(`/api/users/${u.id}`, {
      method: "PUT",
      credentials: "include",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify({
        name: u.name,
        email: u.email,
        role: u.role,
        is_active: u.is_active,
        service: u.service,
        nature_id: u.nature_id
      })
    })
      .then(res => res.json())
      .then(() => {
        alert("Utilisateur modifié avec succès");
      })
      .catch(() => {
        alert("Erreur modification");
      });

  };

  return (

    <div style={{display:"flex"}}>

      {/* 🔥 SIDEBAR */}
      <div style={{
        width:"220px",
        background:"#0f172a",
        color:"white",
        minHeight:"100vh",
        padding:"20px"
      }}>
        <h3>Menu</h3>

        <button onClick={()=>window.location.href="/"} style={btnStyle}>Accueil</button>
        <button onClick={()=>window.location.href="/courriers/create"} style={btnStyle}>Courrier Arrivée</button>
        <button onClick={()=>window.location.href="/courrier-departs/create"} style={btnStyle}>Courrier Départ</button>
        <button onClick={()=>window.location.href="/courriers"} style={btnStyle}>Liste Arrivée</button>
        <button onClick={()=>window.location.href="/courrier-departs"} style={btnStyle}>Liste Départ</button>
        <button onClick={()=>window.location.href="/users"} style={{...btnStyle, background:"#b91c1c"}}>Administration</button>
      </div>

      {/* 🔥 CONTENT */}
      <div className="p-8" style={{flex:1}}>

        <h1 className="text-2xl font-bold mb-6">
          Gestion des Utilisateurs
        </h1>

        <table className="w-full border">

          <thead>
            <tr className="bg-gray-200">
              <th className="p-2">Nom</th>
              <th>Email</th>
              <th>Role</th>
              <th>Service</th>
              <th>Nature</th>
              <th>Statut</th>
              <th>Action</th>
            </tr>
          </thead>

          <tbody>

            {users.map(u => (

              <tr key={u.id} className="border">

                <td className="p-2">{u.name}</td>
                <td>{u.email}</td>

                {/* ROLE */}
                <td>
                  <select
                    value={u.role}
                    onChange={(e) => {
                      u.role = e.target.value;
                      setUsers([...users]);
                    }}
                    className="border p-2 rounded"
                  >
                    <option value="user">User</option>
                    <option value="manager">Manager</option>
                    <option value="admin">Admin</option>
                  </select>
                </td>

                {/* 🔥 SERVICE FIXED */}
                <td>
                  <select
                    value={u.service || ""}
                    onChange={(e) => {
                      u.service = e.target.value;
                      setUsers([...users]);
                    }}
                    className="border p-2 rounded w-full"
                  >
                    <option value="">--</option>

                    {services.map(s => (
                      <option key={s.id} value={s.nom_service}>
                        {s.nom_service}
                      </option>
                    ))}

                  </select>
                </td>

                {/* NATURE */}
                <td>
                  <select
                    value={u.nature_id || ""}
                    onChange={(e) => {
                      u.nature_id = e.target.value;
                      setUsers([...users]);
                    }}
                    className="border p-2 rounded"
                  >
                    <option value="">--</option>

                    {natures.map(n => (
                      <option key={n.id} value={n.id}>
                        {n.nom}
                      </option>
                    ))}

                  </select>
                </td>

                {/* STATUS */}
                <td>
                  <label>
                    <input
                      type="radio"
                      checked={u.is_active}
                      onChange={() => {
                        u.is_active = true;
                        setUsers([...users]);
                      }}
                    /> Actif
                  </label>

                  <label className="ml-2">
                    <input
                      type="radio"
                      checked={!u.is_active}
                      onChange={() => {
                        u.is_active = false;
                        setUsers([...users]);
                      }}
                    /> Désactivé
                  </label>
                </td>

                {/* ACTION */}
                <td>
                  <button
                    onClick={() => updateUser(u)}
                    style={{
                      background:"#16a34a",
                      color:"white",
                      padding:"6px 12px",
                      borderRadius:"6px"
                    }}
                  >
                    Enregistrer
                  </button>
                </td>

              </tr>

            ))}

          </tbody>

        </table>

      </div>

    </div>
  );
}

// 🔥 style buttons sidebar
const btnStyle = {
  display:"block",
  width:"100%",
  marginBottom:"10px",
  padding:"10px",
  background:"#1e293b",
  color:"white",
  border:"none",
  borderRadius:"6px",
  cursor:"pointer"
};