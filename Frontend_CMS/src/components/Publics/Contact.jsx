import collaborationImg from "../../../public/assets/img_app/collaboration.png";

export default function Contact() {
  return (
    <section className="py-24">
      <div className="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">

        {/* Formulaire */}
        <div>
          <h2 className="text-4xl font-bold mb-6 text-[rgb(var(--text))]">
            Contactez-nous
          </h2>

          <p className="text-[rgb(var(--text-muted))] mb-8">
            Une question sur la plateforme, les offres ou un besoin spécifique ?
            Notre équipe est à votre écoute.
          </p>

          <form className="space-y-4">
            <input
              type="text"
              placeholder="Nom"
              className="w-full p-3 rounded-lg border border-[rgb(var(--border))] bg-transparent"
            />

            <input
              type="email"
              placeholder="Email"
              className="w-full p-3 rounded-lg border border-[rgb(var(--border))] bg-transparent"
            />

            <textarea
              rows="5"
              placeholder="Message"
              className="w-full p-3 rounded-lg border border-[rgb(var(--border))] bg-transparent"
            />

            <button
              type="submit"
              className="w-full bg-[rgb(var(--primary))] text-white py-3 rounded-lg font-medium hover:opacity-90 transition"
            >
              Envoyer le message
            </button>
          </form>
        </div>

        {/* Image */}
        <div>
          <img
            src={collaborationImg}
            alt="Collaboration Dev4Earth"
            className="rounded-2xl shadow-xl"
          />
        </div>

      </div>
    </section>
  );
}
