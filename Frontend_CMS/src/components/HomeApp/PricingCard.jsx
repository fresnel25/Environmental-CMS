import React from "react";

export default function PricingCard({ plan, onAction }) {
  return (
    <div
      className={`
        relative flex flex-col
        rounded-3xl p-10
        bg-[rgb(var(--card))]
        border transition-all duration-500
        hover:-translate-y-2 hover:shadow-2xl
        ${
          plan.highlight
            ? "border-[rgb(var(--primary))] ring-2 ring-[rgb(var(--primary))/0.25]"
            : "border-[rgb(var(--border))]"
        }
      `}
    >
      {/* Badge */}
      {plan.highlight && (
        <span className="absolute -top-4 left-6 bg-[rgb(var(--primary))] text-white text-xs font-medium px-4 py-1 rounded-full shadow-md">
          Le plus populaire
        </span>
      )}

      {/* Title */}
      <h3 className="text-3xl font-bold text-[rgb(var(--text))] mb-2">
        {plan.name}
      </h3>

      <p className="text-[rgb(var(--text-muted))] mb-6">
        {plan.description}
      </p>

      {/* Price */}
      <div className="mb-8">
        <span className="text-5xl font-bold text-[rgb(var(--text))]">
          {plan.price}
        </span>
        <p className="text-sm text-[rgb(var(--text-muted))] mt-1">
          {plan.renewal}
        </p>
      </div>

      {/* Features */}
      <ul className="space-y-4 flex-1">
        {plan.features.map((feature, idx) => (
          <li key={idx} className="flex items-start gap-3">
            <span className="mt-2 h-2 w-2 bg-[rgb(var(--primary))] rounded-full shrink-0" />
            <span className="text-[rgb(var(--text))] leading-relaxed">
              {feature}
            </span>
          </li>
        ))}
      </ul>

      {/* CTA */}
      <button
        onClick={onAction}
        className={`
          mt-10 w-full py-3 rounded-xl font-medium text-lg
          transition-all duration-300
          ${
            plan.highlight
              ? "bg-[rgb(var(--primary))] text-white hover:opacity-90"
              : "bg-[rgb(var(--bg-section))] text-[rgb(var(--text))] hover:bg-[rgb(var(--border))]"
          }
        `}
      >
        {plan.cta === "contact"
          ? "Get in touch"
          : "Commencer maintenant"}
      </button>
    </div>
  );
}
